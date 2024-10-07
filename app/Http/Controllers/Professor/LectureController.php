<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Jobs\VideoConvert;
use App\Models\BulkSubtitle;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;

class LectureController extends Controller
{
    protected $professor = null;

    public function __construct()
    {
        $this->professor = Auth::guard('professor')->user();
    }

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
            // 'end_period' => 'required|date|after_or_equal:start_period',
            'description' => 'nullable|string',
            'audio_file' => 'nullable|string',
            'subtitle_file' => 'nullable|string',
            'original_video_file' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($request->audio_file) {
            $audioFile = str_replace("temp/", "", $request->audio_file);
            Storage::move($request->audio_file, 'lecture_audios/' . $audioFile);
            $audio = 'lecture_audios/' . $audioFile;
            $audioFile = new Mp3Info('storage/' . $audio);
            $duration = $audioFile->duration;
        }

        if ($request->subtitle_file) {
            $subtitleFile = str_replace("temp/", "", $request->subtitle_file);
            $subtitleFile = str_replace('.txt', '.srt', $subtitleFile);
            Storage::move($request->subtitle_file, 'lecture_subtitles/' . $subtitleFile);
            $mainSubtitle = 'lecture_subtitles/' . $subtitleFile;

            $subtitle = new BulkSubtitle();
            $subtitle->original_filename = $subtitleFile;
            $subtitle->label = $request->label ? $request->label : 'korean';
            $subtitle->filename = $mainSubtitle;
            $subtitle->save();
        }

        $lecture = Lecture::create([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'professor_id' => $this->professor->id,
            'semester_id' => $request->semester_id,
            'start_period' => $request->start_period,
            'end_period' => date('Y-m-d', strtotime($request->start_period . ' + 15 days')),
            'description' => $request->description,
            'audio_file' => $request->audio_file ? $audio : null,
            'original_video_file' => $request->original_video_file ?? null,
            'audio_duration' => $request->audio_file ? $duration : null,
            'convert_status' => $request->original_video_file ? 'Pending' : 'No Video',
            'status' => $request->status,
            'bulk_subtitle_id' => isset($subtitle) ? $subtitle->id : '',
            'subtitle_file' => isset($subtitle) ? $subtitle->filename : '',
            'subtitle_label' => isset($subtitle) ? $subtitle->label : '',
        ]);

        if ($request->original_video_file)
            VideoConvert::dispatch($lecture, $request->original_video_file);

        return new LectureResource($lecture);
    }

    public function show(Lecture $lecture, Request $request)
    {
        return new LectureResource($lecture->load('professor', 'subject', 'semester'));
    }

    public function update(Request $request, Lecture $lecture)
    {
        $request->validate([
            'name' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_period' => 'required|date',
            // 'end_period' => 'required|date|after_or_equal:start_period',
            'description' => 'nullable|string',
            'audio_file' => 'nullable|string',
            'original_video_file' => 'nullable|string',
            'status' => 'required|boolean',
            'subtitle_file' => 'nullable|string',
        ]);

        $lecture->name = $request->name ?? $lecture->name;
        $lecture->subject_id = $request->subject_id ?? $lecture->subject_id;
        $lecture->semester_id = $request->semester_id ?? $lecture->semester_id;

        if ($request->audio_file) {
            $audioFile = str_replace("temp/", "", $request->audio_file);
            Storage::move($request->audio_file, 'lecture_audios/' . $audioFile);
            $audio = 'lecture_audios/' . $audioFile;
            $lecture->audio_file = $audio;

            $audio = new Mp3Info('storage/' . $audio);
            $lecture->audio_duration = floor($audio->duration);
        }

        if ($request->subtitle_file) {
            $subtitleFile = str_replace("temp/", "", $request->subtitle_file);
            $subtitleFile = str_replace('.txt', '.srt', $subtitleFile);
            Storage::move($request->subtitle_file, 'lecture_subtitles/' . $subtitleFile);
            $mainSubtitle = 'lecture_subtitles/' . $subtitleFile;

            $subtitle = new BulkSubtitle();
            $subtitle->original_filename = $subtitleFile;
            $subtitle->label = $request->label ? $request->label : 'korean';
            $subtitle->filename = $mainSubtitle;
            $subtitle->save();
        }

        $lecture->description = $request->description ?? $lecture->description;
        $lecture->start_period = $request->start_period;
        $lecture->end_period = date('Y-m-d', strtotime($request->start_period . ' + 15 days'));
        $lecture->status = $request->status;

        $lecture->bulk_subtitle_id = isset($subtitle) ? $subtitle->id : $lecture->bulk_subtitle_id;
        $lecture->subtitle_file = isset($subtitle) ? $subtitle->filename : $lecture->subtitle_file;
        $lecture->subtitle_label = isset($subtitle) ? $subtitle->label : $lecture->subtitle_label;

        if ($request->original_video_file) {
            $lecture->original_video_file = $request->original_video_file;
            $lecture->original_video = null;
            $lecture->duration = null;
            $lecture->smil = null;
            $lecture->q_480 = null;
            $lecture->q_720 = null;
            $lecture->q_1080 = null;
            $lecture->convert_status = 'Pending';
        }

        $lecture->save();

        if ($request->original_video_file)
            VideoConvert::dispatch($lecture, $request->original_video_file);

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

    public function fileCopy($file = null, $path)
    {
        if ($file) {
            $mainFile = str_replace($path, "", $file);
            $newFile = $path . Str::uuid() . $mainFile;
            Storage::copy($file, $newFile);
            return $newFile;
        }
    }
}
