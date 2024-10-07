<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CopySubtitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lecture, $url, $label;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lecture, $url, $label)
    {
        $this->onQueue('copy_subtitle');

        $this->lecture = $lecture;
        $this->url = $url;
        $this->label = $label;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = Str::uuid() . '.' . pathinfo($this->url)['extension'];
        Storage::disk('public')->copy($this->url, 'lecture_subtitles/' . $filename);

        $this->lecture->subtitle_file = 'lecture_subtitles/' . $filename;
        $this->lecture->subtitle_label = $this->label;
        $this->lecture->save();
    }
}
