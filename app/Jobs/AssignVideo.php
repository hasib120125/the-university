<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class AssignVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $video, $lecture, $filename, $filenameWithoutExt;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video, $lecture)
    {
        $this->onQueue('assign_video');

        $this->video = $video;
        $this->lecture = $lecture;

        $this->filenameWithoutExt = Str::uuid();
        $this->filename = $this->filenameWithoutExt.'.mp4';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->video->can_assign = 0;
        $this->video->save();

        $this->lecture->convert_status = 'Deleting Previous files';
        $this->lecture->save();

        $this->deletePreviousContents();

        $columns = [
            [
                'name' => 'q_480',
                'path' => 'lecture/480/',
                'width' => 850,
                'height' => 480,
                'videoBitRate' => 1000,
            ],
            [
                'name' => 'q_720',
                'path' => 'lecture/720/',
                'width' => 1280,
                'height' => 720,
                'videoBitRate' => 2500,
            ],
            [
                'name' => 'q_1080',
                'path' => 'lecture/1080/',
                'width' => 1920,
                'height' => 1080,
                'videoBitRate' => 5000,
            ]
        ];

        $toConvert = [];

        foreach ($columns as $column) {
            $columnName = $column['name'];

            if ($this->video->$columnName) {
                $this->video->convert_status = 'Copying ' . $column['height'] . 'p';
                $this->video->save();

                $this->lecture->convert_status = 'Copying ' . $column['height'] . 'p';
                $this->lecture->save();

                Storage::disk('media_server')->copy($this->video->$columnName, $column['path'] . $this->filename);

                $this->lecture->$columnName = $column['path'] . $this->filename;
                $this->lecture->save();
                $toConvert[] = $column;
            }
        }

        // Moving Thumb
        Storage::disk('public')->copy($this->video->thumbs, 'lecture_thumbs/'.$this->filenameWithoutExt.'.png');

        // Create SMIL file
        $smilFileName = Str::uuid();
        $smilArray = '';

        $this->video->convert_status = 'Creating SMIL';
        $this->video->save();

        $this->lecture->convert_status = 'Creating SMIL';
        $this->lecture->save();

        foreach($toConvert as $convert) {
            $smilArray .= '{
                "systemLanguage": "en",
                "src": "'.$convert['path'].$this->filenameWithoutExt.'.mp4",
                "type": "video",
                "audioBitrate": "44100",
                "videoBitrate": "'.$convert['videoBitRate'].'",
                "restURI": "http://'.config('services.media_server.host').':8087/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/vod/smilfiles/'.$smilFileName.'",
                "width": "'.$convert['width'].'",
                "height": "'.$convert['height'].'"
              },';
        }

        $smilArray = rtrim($smilArray, ',');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ])
            ->withDigestAuth(config('services.wowza.username'), config('services.wowza.password'))
            ->withBody(
                '{
                "restURI": "http://'.config('services.media_server.host').':8087/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/vod/smilfiles/'.$smilFileName.'",
                "smilStreams": ['.$smilArray.']
              }', 'application/json'
            )
            ->post('http://'.config('services.media_server.host').':8087/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/vod/smilfiles/'.$smilFileName);

        if ($response->successful()) {
            $this->lecture->original_video_file = $this->video->original_video;
            $this->lecture->duration = $this->video->duration;
            $this->lecture->thumbs = 'lecture_thumbs/'.$this->filenameWithoutExt.'.png';
            $this->lecture->smil = $smilFileName.'.smil';
            $this->lecture->bulk_video_id = $this->video->id;

            $this->lecture->convert_status = 'Completed';
            $this->video->convert_status = 'Completed';
        } else {
            $this->lecture->convert_status = $response->json('message');
            $this->video->convert_status = $response->json('message');
        }

        $this->video->can_assign = 1;
        $this->lecture->save();
        $this->video->save();
    }

    public function deletePreviousContents()
    {
        $qualitiesArray = ['q_480', 'q_720', 'q_1080'];

        foreach ($qualitiesArray as $quality) {
            if ($this->lecture->$quality != null) {
                if (Storage::disk('media_server')->exists($this->lecture->$quality)) {
                    Storage::disk('media_server')->delete($this->lecture->$quality);
                    $this->lecture->$quality = null;
                }
            }
        }

        $this->lecture->duration = null;
        $this->lecture->smil = null;
        $this->lecture->convert_status = 'Pending';
        $this->lecture->save();
    }

    public function failed(Throwable $exception)
    {
        $this->video->can_assign = 1;
        $this->lecture->convert_status = $exception->getMessage();
        $this->video->convert_status = $exception->getMessage();
        $this->video->save();
    }
}
