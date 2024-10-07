<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulkAudioResource;
use App\Http\Resources\LectureResource;
use App\Jobs\CopyAudio;
use App\Models\BulkAudio;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use wapmorgan\Mp3Info\Mp3Info;

class BulkAudioController extends Controller
{
    public function index()
    {
        return BulkAudioResource::collection(executeQuery(BulkAudio::query()));
    }

    public function assignAudioToLecture(Request $request, BulkAudio $bulkAudio)
    {
        $request->validate([
            'lecture_id'=> 'required|integer|exists:lectures,id',
        ]);

        $lecture = Lecture::find($request->lecture_id);

        CopyAudio::dispatch($lecture, $bulkAudio->filename);

        return true;
    }

    public function loadLecture(Request $request){
        return LectureResource::collection(executeQuery(Lecture::query()->where('subject_id', $request->subjectId)->where('semester_id', $request->semesterId)));
    }

    public function destroy(BulkAudio $bulkAudio)
    {
        if (Storage::exists($bulkAudio->getOriginal('filename'))) {
            Storage::delete($bulkAudio->getOriginal('filename'));
        }

        $bulkAudio->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
