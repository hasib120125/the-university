<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\AssignVideo;
use App\Jobs\VideoConvert;
use App\Models\Lecture;
use App\Models\BulkVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BulkVideoResource;

class BulkVideoController extends Controller
{
    public function index()
    {
        return BulkVideoResource::collection(executeQuery(BulkVideo::query()));
    }

    public function forLecture()
    {
        return BulkVideoResource::collection(executeQuery(BulkVideo::query()->where('can_assign', 1)));
    }

    public function assignVideoToLecture(Request $request, BulkVideo $bulkVideo)
    {
        $request->validate([
            'lecture_id'=> 'required|integer|exists:lectures,id',
        ]);

        $lecture = Lecture::find($request->lecture_id);

        AssignVideo::dispatch($bulkVideo, $lecture);

        return true;
    }

    public function loadLecture(Request $request){
        return LectureResource::collection(executeQuery(Lecture::query()->where('subject_id', $request->subjectId)->where('semester_id', $request->semesterId)));
    }

    public function retry(BulkVideo $bulkVideo)
    {
        $bulkVideo->fail = 0;
        $bulkVideo->convert_status = 'Pending';
        $bulkVideo->save();

        VideoConvert::dispatch($bulkVideo, $bulkVideo->filename);
    }

    public function convertAgain(BulkVideo $bulkVideo)
    {
        if (Storage::exists($bulkVideo->thumbs))
            Storage::delete($bulkVideo->thumbs);

        if (Storage::disk('media_server')->exists($bulkVideo->smil))
            Storage::disk('media_server')->delete($bulkVideo->smil);

        if (Storage::disk('media_server')->exists($bulkVideo->q_480))
            Storage::disk('media_server')->delete($bulkVideo->q_480);

        if (Storage::disk('media_server')->exists($bulkVideo->q_720))
            Storage::disk('media_server')->delete($bulkVideo->q_720);

        if (Storage::disk('media_server')->exists($bulkVideo->q_1080))
            Storage::disk('media_server')->delete($bulkVideo->q_1080);

        $bulkVideo->smil = null;
        $bulkVideo->q_480 = null;
        $bulkVideo->q_720 = null;
        $bulkVideo->q_1080 = null;
        $bulkVideo->convert_status = 'Pending';
        $bulkVideo->save();

        VideoConvert::dispatch($bulkVideo, $bulkVideo->original_video);
    }

    public function destroy(BulkVideo $bulkVideo)
    {
        if (Storage::exists($bulkVideo->original_video))
            Storage::delete($bulkVideo->original_video);

        if (Storage::exists($bulkVideo->thumbs))
            Storage::delete($bulkVideo->thumbs);

        if (Storage::disk('media_server')->exists($bulkVideo->original_video))
            Storage::disk('media_server')->delete($bulkVideo->original_video);

        if (Storage::disk('media_server')->exists($bulkVideo->smil))
            Storage::disk('media_server')->delete($bulkVideo->smil);

        if (Storage::disk('media_server')->exists($bulkVideo->q_480))
            Storage::disk('media_server')->delete($bulkVideo->q_480);

        if (Storage::disk('media_server')->exists($bulkVideo->q_720))
            Storage::disk('media_server')->delete($bulkVideo->q_720);

        if (Storage::disk('media_server')->exists($bulkVideo->q_1080))
            Storage::disk('media_server')->delete($bulkVideo->q_1080);

        $bulkVideo->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
