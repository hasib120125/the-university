<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\FtpFileCheck;
use App\Models\BulkVideo;
use App\Jobs\VideoConvert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BulkAudio;
use App\Models\BulkSubtitle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;
use wapmorgan\Mp3Info\Mp3Info;

class FileUploadController extends Controller
{
    public function checkFtp()
    {
        FtpFileCheck::dispatch();
    }

    public function tempFileUpload(Request $request)
    {
        return $request->file('file') ? $request->file('file')->store('temp') : null;
    }

    public function tempVideoFileUpload(Request $request)
    {
        return $request->file('file') ?  $request->file('file')->store(
            'temp',
            'media_server'
        ) : null;
    }

    public function tempSubtitleFileUpload(Request $request)
    {
        return $request->file('file') ? $request->file('file')->store('temp') : null;
    }

    public function imageFileUpload(Request $request)
    {
        if ($request->froala) {
            $file = $request->file('image') ? Storage::url($request->file('image')->store('images')) : null;
            $response = new stdClass;
            $response->link = $file;
            if ($file)
                return  stripslashes(json_encode($response));
        }
        return $request->file('image') ? Storage::url($request->file('image')->store('images')) : null;
    }

    public function videoFileUpload(Request $request)
    {
        if ($request->froala) {
            $file = $request->file('video') ? Storage::url($request->file('video')->store('videos')) : null;
            $response = new stdClass;
            $response->link = $file;
            if ($file)
                return  stripslashes(json_encode($response));
        }
        return $request->file('video') ? Storage::url($request->file('video')->store('videos')) : null;
    }

    public function imageFileDelete(Request $request)
    {
        foreach ($request->images as $image) {
            $filename = basename($image);

            if (Storage::exists('images/' . $filename))
                Storage::delete('images/' . $filename);
        }
    }

    public function deleteTempFile(Request $request)
    {
        if (Storage::exists($request->deleteFile)) {
            Storage::delete($request->deleteFile);
        }
    }

    public function bulkVideoFileUpload(Request $request)
    {
        for ($i = 0; $i < count($request->input('files')); $i++) {
            $video = new BulkVideo();
            $video->filename = $request->input('files')[$i];
            $video->original_filename = $request->originalFiles[$i];
            $video->convert_status = "Pending";
            $video->save();

            VideoConvert::dispatch($video, $request->input('files')[$i]);
        }
    }

    public function bulkVideoFileDelete(Request $request)
    {
        if (Storage::exists($request->deleteFile)) {
            Storage::delete($request->deleteFile);
        }
    }

    public function bulkAudioFileUpload(Request $request)
    {
        for ($i = 0; $i < count($request->input('files')); $i++) {
            $audioFile = str_replace("temp/", "", $request->input('files')[$i]);
            Storage::move($request->input('files')[$i], 'lecture_audios/' . $audioFile);
            $mainAudio = 'lecture_audios/' . $audioFile;
            $audioFile = new Mp3Info('storage/' . $mainAudio);
            $duration = $audioFile->duration;

            $audio = new BulkAudio();
            $audio->original_filename = $request->originalFiles[$i];
            $audio->filename = $mainAudio;
            $audio->duration = floor($duration);
            $audio->save();
        }
    }

    public function bulkAudioFileDelete(Request $request)
    {
        if (Storage::exists($request->deleteFile)) {
            Storage::delete($request->deleteFile);
        }
    }

    public function bulkSubtitleFileUpload(Request $request)
    {
        for ($i = 0; $i < count($request->input('files')); $i++) {
            $subtitleFile = str_replace("temp/", "", $request->input('files')[$i]);
            $subtitleFile = str_replace('.txt', '.srt', $subtitleFile);
            Storage::move($request->input('files')[$i], 'lecture_subtitles/' . $subtitleFile);
            $mainSubtitle = 'lecture_subtitles/' . $subtitleFile;

            $subtitle = new BulkSubtitle();
            $subtitle->original_filename = $request->originalFiles[$i];
            $subtitle->label = $request->label ? $request->label : 'korean';
            $subtitle->filename = $mainSubtitle;
            $subtitle->save();
        }
    }

    public function bulkSubtitleFileDelete(Request $request)
    {
        if (Storage::exists($request->deleteFile)) {
            Storage::delete($request->deleteFile);
        }
    }
}
