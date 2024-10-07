<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;

class CopyAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lecture, $url;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lecture, $url)
    {
        $this->onQueue('copy_audio');

        $this->lecture = $lecture;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = Str::uuid().'.'.pathinfo($this->url)['extension'];
        Storage::disk('public')->copy($this->url, 'lecture_audios/'.$filename);

        $audioFile = new Mp3Info(Storage::path($this->url));
        $duration = $audioFile->duration;

        $this->lecture->audio_file = 'lecture_audios/'.$filename;
        $this->lecture->audio_duration = floor($duration);
        $this->lecture->save();
    }
}
