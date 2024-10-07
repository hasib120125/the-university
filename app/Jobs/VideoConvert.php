<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\ProgressListenerDecorator;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Throwable;

class VideoConvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $item, $videoUrl, $filename, $filenameWithoutExt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($item, $videoUrl)
    {
        $this->onQueue('video_convert');

        $this->item = $item;
        $this->videoUrl = $videoUrl;
        $this->filename = basename($videoUrl);
        $this->filenameWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($videoUrl));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $format = (new X264('aac'))->setAdditionalParameters(['-crf', '20', '-preset', 'ultrafast', '-bufsize', '1k'])->setPasses(1);

        $videoQualities = [
            [
                'width' => 1920,
                'height' => 1080,
                'videoBitRate' => 5000,
                'path' => 'lecture/1080/',
            ],
            [
                'width' => 1280,
                'height' => 720,
                'videoBitRate' => 2500,
                'path' => 'lecture/720/',
            ],
        ];

        $dimension = FFMpeg::fromDisk('media_server')
            ->open($this->videoUrl)
            ->getVideoStream()
            ->getDimensions();

        $height = $dimension->getHeight();

        $durationInSeconds = FFMpeg::fromDisk('media_server')
            ->open($this->videoUrl)->getDurationInSeconds();

        FFMpeg::fromDisk('media_server')
            ->open($this->videoUrl)
            ->getFrameFromSeconds(random_int(0, $durationInSeconds))
            ->export()
            ->toDisk('public')
            ->save('lecture_thumbs/'.$this->filenameWithoutExt.'.png');

        $toConvert = [
            [
                'width' => 850,
                'height' => 480,
                'videoBitRate' => 1000,
                'path' => 'lecture/480/',
            ]
        ];

        foreach ($videoQualities as $quality) {
            if ($quality['height'] <= $height) {
                $toConvert[] = $quality;
            }
        }

        $decoratedFormat = ProgressListenerDecorator::decorate($format);

        $smilDataArray = [];

        foreach($toConvert as $convert) {
            $columnName = 'q_'.$convert['height'];
            $smilTmp = $convert;

            if ($this->item->$columnName) {
                $smilTmp['url'] = $this->item->$columnName;
            } else {
                $this->item->convert_status = $convert['height'].'p Converting (0%)';
                $this->item->save();

                try {
                    FFMpeg::fromDisk('media_server')
                        ->open($this->videoUrl)
                        ->export()
                        ->resize($convert['width'], $convert['height'], 'width')
                        ->inFormat($decoratedFormat)
                        ->onProgress(function ($percentage) use ($convert) {
                            $this->item->convert_status = $convert['height'].'p Converting ('.$percentage.'%)';
                            $this->item->save();
                        })
                        ->toDisk('media_server')
                        ->save($convert['path'].$this->filenameWithoutExt.'.mp4');
                } catch (\Exception $exception) {
                    $this->item->convert_status = $exception->getMessage();
                    $this->item->fail = 1;
                    $this->item->save();
                }

                $smilTmp['url'] = $convert['path'].$this->filenameWithoutExt.'.mp4';
            }

            //$this->item->$columnName = $convert['path'].$this->filenameWithoutExt.'.mp4';
            $smilDataArray[] = $smilTmp;
            $this->item->$columnName = $smilTmp['url'];
            $this->item->convert_status = $convert['height'].'p Uploaded';
            $this->item->save();
        }

        $this->item->convert_status = 'All Video Uploaded';
        $this->item->save();

        FFMpeg::cleanupTemporaryFiles();

        $this->item->convert_status = 'Creating SMIL';
        $this->item->save();

        // Create SMIL file
        $smilFileName = (string) Str::uuid();
        $smilArray = '';

        foreach($smilDataArray as $convert) {
            $smilArray .= '{
                "systemLanguage": "en",
                "src": "'.$convert['url'].'",
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
            $this->item->convert_status = 'Moving Video';
            $this->item->save();

            try {
                Storage::disk('media_server')->move($this->videoUrl, str_replace("temp","lecture/original", $this->videoUrl));

                //Storage::disk('media_server')->put('lecture/original/' . $this->filename, Storage::disk('public')->get($this->videoUrl));

                /*if (Storage::disk('public')->exists($this->videoUrl)) {
                    Storage::disk('public')->delete($this->videoUrl);
                }*/
            } catch (\Exception $exception) {

            }

            $this->item->original_video = 'lecture/original/'.$this->filename;
            $this->item->duration = $durationInSeconds;
            $this->item->thumbs = 'lecture_thumbs/'.$this->filenameWithoutExt.'.png';
            $this->item->smil = $smilFileName.'.smil';
            $this->item->convert_status = 'Completed';
            $this->item->can_assign = 1;
            $this->item->fail = 0;
        } else {
            $this->item->fail = 1;
            $this->item->can_assign = 0;
            $this->item->convert_status = $response->json('message');
        }

        $this->item->save();
    }

    public function failed(Throwable $exception)
    {
        $this->item->fail = 1;
        $this->item->convert_status = $exception->getMessage();
        $this->item->save();
    }
}
