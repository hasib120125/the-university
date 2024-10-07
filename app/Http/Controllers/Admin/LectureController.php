<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Jobs\AssignVideo;
use App\Jobs\CopyAudio;
use App\Jobs\VideoConvert;
use App\Models\BulkAudio;
use App\Models\BulkSubtitle;
use App\Models\BulkVideo;
use App\Models\Lecture;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        return LectureResource::collection(executeQuery(Lecture::query()->with('professor', 'subject', 'semester')));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_period' => 'required|date',
            'end_period' => 'nullable|date',
            'bulk_video_id' => 'nullable|integer',
            'bulk_audio_id' => 'nullable|integer',
            'bulk_subtitle_id' => 'nullable|integer',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $subject = Subject::where('id', $request->subject_id)->with('professor')->first();

        $lecture = Lecture::create([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'professor_id' => $subject->professor->id,
            'semester_id' => $request->semester_id,
            'bulk_video_id' => $request->bulk_video_id,
            'bulk_audio_id' => $request->bulk_audio_id,
            'bulk_subtitle_id' => $request->bulk_subtitle_id,
            'start_period' => $request->start_period,
            'end_period' => $request->end_period ? $request->end_period : date('Y-m-d', strtotime($request->start_period . ' + 15 days')),
            'description' => $request->description,
            'status' => $request->status
        ]);

        if ($request->bulk_audio_id) {
            $bulkAudio = BulkAudio::find($request->bulk_audio_id);

            CopyAudio::dispatch($lecture, $bulkAudio->filename);
        }

        if ($request->bulk_video_id) {
            $bulkVideo = BulkVideo::find($request->bulk_video_id);
            AssignVideo::dispatch($bulkVideo, $lecture);
        }
        if ($request->bulk_subtitle_id) {
            $bulkSubtitle = BulkSubtitle::find($request->bulk_subtitle_id);
            $lecture->update([
                'subtitle_file' => $bulkSubtitle->filename,
                'subtitle_label' => $bulkSubtitle->label,
            ]);
        }

        return new LectureResource($lecture);
    }

    public function show(Lecture $lecture, Request $request)
    {
        return new LectureResource($lecture->load('professor', 'subject', 'semester', 'bulkAudio', 'bulkVideo', 'bulkSubtitle'));
    }

    public function update(Request $request, Lecture $lecture)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_period' => 'required|date',
            'end_period' => 'nullable|date',
            'description' => 'nullable|string',
            'bulk_video_id' => 'nullable|integer',
            'bulk_audio_id' => 'nullable|integer',
            'bulk_subtitle_id' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $lecture->name = $request->name ?? $lecture->name;
        $lecture->subject_id = $request->subject_id ?? $lecture->subject_id;
        $lecture->semester_id = $request->semester_id ?? $lecture->semester_id;
        $lecture->bulk_video_id = $request->bulk_video_id;
        $lecture->bulk_audio_id = $request->bulk_audio_id;
        $lecture->bulk_subtitle_id = $request->bulk_subtitle_id;

        $lecture->description = $request->description ?? $lecture->description;
        $lecture->start_period = $request->start_period;
        $lecture->end_period = $request->end_period ? $request->end_period : date('Y-m-d', strtotime($request->start_period . ' + 15 days'));
        $lecture->status = $request->status;

        $lecture->save();

        if ($request->bulk_audio_id) {
            $bulkAudio = BulkAudio::find($request->bulk_audio_id);

            CopyAudio::dispatch($lecture, $bulkAudio->filename);
        }

        if ($request->bulk_video_id) {
            $bulkVideo = BulkVideo::find($request->bulk_video_id);
            AssignVideo::dispatch($bulkVideo, $lecture);
        }

        if ($request->bulk_subtitle_id) {
            $bulkSubtitle = BulkSubtitle::find($request->bulk_subtitle_id);
            $lecture->update([
                'subtitle_file' => $bulkSubtitle->filename,
                'subtitle_label' => $bulkSubtitle->label,
            ]);
        }

        return new LectureResource($lecture);
    }

    public function destroy(Lecture $lecture)
    {
        $lecture->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function clone(Lecture $lecture)
    {
        $filename = null;

        if ($lecture->original_video) {
            $filetype = pathinfo($lecture->original_video)['extension'];
            $filename = 'temp/' . Str::uuid() . '.' . $filetype;

            Storage::disk('public')->writeStream($filename, Storage::disk('media_server')->readStream($lecture->original_video));
        }

        $newLecture = Lecture::create([
            'name' => $lecture->name . ' - Clone',
            'subject_id' => $lecture->subject_id,
            'professor_id' => $lecture->professor_id,
            'semester_id' => $lecture->semester_id,
            'start_period' => $lecture->start_period,
            'end_period' => $lecture->end_period,
            'description' => $lecture->description,
            'audio_file' => $lecture->audio_file,
            'original_video_file' => $filename,
            'audio_duration' => $lecture->audio_duration,
            'convert_status' => $filename ? 'Pending' : $lecture->convert_status,
            'status' => false
        ]);

        if ($filename) {
            VideoConvert::dispatch($newLecture, $filename);
        }
    }
}
