<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureManagementResource;
use App\Jobs\VideoConvert;
use App\Models\Lecture;
use App\Models\LectureManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use wapmorgan\Mp3Info\Mp3Info;

class LectureManagementController extends Controller
{
    public function index(Lecture $lecture)
    {
        return LectureManagementResource::collection(executeQuery($lecture->managements()));
    }

    public function store(Request $request, Lecture $lecture)
    {
        $request->validate([
            'lecture_number' => 'required|integer',
            'lecture_name' => 'required|string',
            'audio' => 'required|required',
            'file' => 'nullable|string',
            'video_running_time' => 'nullable|date_format:H:i:s',
            'description' => 'nullable|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after_or_equal:start_period'
        ]);

        $audioFile= str_replace("temp/","", $request->audio);
        Storage::move($request->audio, 'lecture_audios/' . $audioFile);
        $audio = 'lecture_audios/' . $audioFile;
        $audioFile = new Mp3Info('storage/'.$audio);
        $duration = $audioFile->duration;

        $management = $lecture->managements()->create([
            'lecture_number' => $request->lecture_number,
            'lecture_name' => $request->lecture_name,
            'audio' => $audio,
            'file' => $request->file ?? null,
            'audio_duration' => $duration,
            'video_running_time' => $request->video_running_time,
            'description' => $request->description,
            'start_period' => $request->start_period,
            'end_period' => $request->end_period,
            'convert_status' => 'Pending'
        ]);

        if ($request->file)
            VideoConvert::dispatch($management, $request->file);

        return new LectureManagementResource($management);
    }

    public function show(Lecture $lecture, LectureManagement $management)
    {
        return new LectureManagementResource($management);
    }

    public function update(Request $request, Lecture $lecture, LectureManagement $management)
    {
        $request->validate([
            'lecture_number' => 'required|integer',
            'lecture_name' => 'required|string',
            'audio' => 'nullable|string',
            'file' => 'nullable|string',
            'video_running_time' => 'nullable|date_format:H:i:s',
            'description' => 'nullable|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after_or_equal:start_period'
        ]);

        $management->lecture_number = $request->lecture_number ?? $management->lecture_number;
        $management->lecture_name = $request->lecture_name ?? $management->lecture_name;

        if($request->audio){
            $audioFile= str_replace("temp/","", $request->audio);
            Storage::move($request->audio, 'lecture_audios/' . $audioFile);
            $audio = 'lecture_audios/' . $audioFile;
            $management->audio = $audio;

            $audio = new Mp3Info('storage/'.$audio);
            $management->audio_duration = floor($audio->duration);
        }

        $management->video_running_time = $request->video_running_time;
        $management->description = $request->description ?? $management->description;
        $management->start_period = $request->start_period ?? $management->start_period;
        $management->end_period = $request->end_period ?? $management->end_period;

        if ($request->file) {
            $management->file = $request->file;
            $management->original_video = null;
            $management->duration = null;
            $management->smil = null;
            $management->q_480 = null;
            $management->q_720 = null;
            $management->q_1080 = null;
            $management->convert_status = 'Pending';
        }

        $management->save();

        if ($request->file)
            VideoConvert::dispatch($management, $request->file);

        return new LectureManagementResource($management);
    }

    public function destroy(Lecture $lecture, LectureManagement $management)
    {
        $management->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
