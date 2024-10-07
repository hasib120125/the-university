<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectNoticeCommentResource;
use App\Http\Resources\SubjectNoticeResource;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectNoticeController extends Controller
{
    public function index(SubjectActiveStudent $subject)
    {
        $query = SubjectNotice::query()->where('subject_id', $subject->subject_id)
            ->where('semester_id', $subject->semester_id)->with('comments')->latest();

        return SubjectNoticeResource::collection(executeQuery($query));
    }


    public function addComment(Request $request, SubjectNotice $notice)
    {
        $request->validate([
            'comment' => 'required|string|max:255'
        ]);

        $notice->comments()->create([
            'student_id' => Auth::guard('student')->user()->id,
            'comment' => $request->comment
        ]);

        return SubjectNoticeCommentResource::collection($notice->comments->load('student'));
    }

    public function getComments(SubjectNotice $notice)
    {
        return SubjectNoticeCommentResource::collection($notice->comments);
    }
}
