<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulkSubtitleResource;
use App\Http\Resources\LectureResource;
use App\Jobs\CopySubtitle;
use App\Models\BulkSubtitle;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BulkSubtitleController extends Controller
{
    public function index()
    {
        return BulkSubtitleResource::collection(executeQuery(BulkSubtitle::query()));
    }

    public function assignSubtitleToLecture(Request $request, BulkSubtitle $bulkSubtitle)
    {
        $request->validate([
            'lecture_id' => 'required|integer|exists:lectures,id',
        ]);

        $lecture = Lecture::find($request->lecture_id);

        $lecture->bulk_subtitle_id = $bulkSubtitle->id;
        $lecture->subtitle_file = $bulkSubtitle->filename;
        $lecture->subtitle_label = $bulkSubtitle->label;
        $lecture->save();

        // CopySubtitle::dispatch($lecture, $bulkSubtitle->filename, $bulkSubtitle->label);

        return response()->json(['success' => true, 'message' => 'Successfully assigned.']);
    }

    public function loadLecture(Request $request)
    {
        return LectureResource::collection(executeQuery(Lecture::query()->where('subject_id', $request->subjectId)->where('semester_id', $request->semesterId)));
    }

    public function destroy(BulkSubtitle $bulkSubtitle)
    {
        if (Storage::exists($bulkSubtitle->getOriginal('filename'))) {
            Storage::delete($bulkSubtitle->getOriginal('filename'));
        }

        $bulkSubtitle->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
