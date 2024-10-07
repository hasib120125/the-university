<?php

namespace App\Jobs;

use App\Models\BulkAudio;
use App\Models\BulkSubtitle;
use App\Models\BulkVideo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;

class FtpFileCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue('ftp_check');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = Storage::disk('media_server')->allfiles('ftp/video');
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = Str::uuid() . '.' . $ext;

            Storage::disk('media_server')->move($file, 'temp/' . $filename);

            $originalFilename = str_replace('ftp/video/', '', $file);

            $video = new BulkVideo();
            $video->filename = 'temp/' . $filename;
            $video->original_filename = $originalFilename;
            $video->convert_status = "Pending";
            $video->save();

            VideoConvert::dispatch($video, $video->filename);
        }

        $files = Storage::disk('public')->allfiles('ftp/audio');

        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = Str::uuid() . '.' . $ext;

            Storage::disk('public')->move($file, 'lecture_audios/' . $filename);

            $originalFilename = str_replace('ftp/audio/', '', $file);

            $audio = new BulkAudio();
            $audio->original_filename = $originalFilename;
            $audio->filename = 'lecture_audios/' . $filename;
            $audio->duration = 0;
            $audio->save();
        }

        $files = Storage::disk('public')->allfiles('ftp/korean-subtitle');

        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = Str::uuid() . '.' . $ext;

            Storage::disk('public')->move($file, 'lecture_subtitles/' . $filename);

            $originalFilename = str_replace('ftp/korean-subtitle/', '', $file);

            $subtitle = new BulkSubtitle();
            $subtitle->original_filename = $originalFilename;
            $subtitle->filename = 'lecture_subtitles/' . $filename;
            $subtitle->label = 'korean';
            $subtitle->save();
        }

        $files = Storage::disk('public')->allfiles('ftp/english-subtitle');

        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $filename = Str::uuid() . '.' . $ext;

            Storage::disk('public')->move($file, 'lecture_subtitles/' . $filename);

            $originalFilename = str_replace('ftp/english-subtitle/', '', $file);

            $subtitle = new BulkSubtitle();
            $subtitle->original_filename = $originalFilename;
            $subtitle->filename = 'lecture_subtitles/' . $filename;
            $subtitle->label = 'english';
            $subtitle->save();
        }
    }
}
