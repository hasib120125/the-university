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

class CopyVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $oldLecture, $newLecture, $filename, $filenameWithoutExt;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($oldLecture, $newLecture)
    {
        $this->onQueue('copy_video');

        $this->oldLecture = $oldLecture;
        $this->newLecture = $newLecture;

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

            if ($this->oldLecture->$columnName) {
                $this->newLecture->convert_status = 'Copying ' . $column['height'] . 'p';
                $this->newLecture->save();

                Storage::disk('media_server')->copy($this->oldLecture->$columnName, $column['path'] . $this->filename);

                $this->newLecture->$columnName = $column['path'] . $this->filename;
                $toConvert[] = $column;
            }
        }

        // Moving Thumb
        Storage::disk('public')->copy($this->oldLecture->thumbs, 'lecture_thumbs/'.$this->filenameWithoutExt.'.png');

        // Create SMIL file
        $smilFileName = Str::uuid();
        $smilArray = '';

        $this->newLecture->convert_status = 'Creating SMIL';
        $this->newLecture->save();

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
            $this->newLecture->duration = $this->oldLecture->duration;
            $this->newLecture->thumbs = 'lecture_thumbs/'.$this->filenameWithoutExt.'.png';
            $this->newLecture->smil = $smilFileName.'.smil';

            $this->newLecture->convert_status = 'Completed';
        } else {
            $this->newLecture->convert_status = $response->json('message');
        }
    }
}
