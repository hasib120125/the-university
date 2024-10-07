<?php

namespace App\Http\Controllers\Student;

use App\Http\Resources\SubjectMaterialCommentResource;
use App\Http\Resources\SubjectMaterialResource;
use App\Models\Subject;
use App\Models\SubjectMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubjectActiveStudent;
use Illuminate\Support\Facades\Auth;

class SubjectMaterialController extends Controller
{
    public function index(SubjectActiveStudent $subject)
    {
        return SubjectMaterialResource::collection(executeQuery(
            SubjectMaterial::query()
                ->where('subject_id', $subject->subject_id)
                ->where('semester_id', $subject->semester_id)
        ));
    }

    public function show(SubjectActiveStudent $subject, SubjectMaterial $material)
    {
        return new SubjectMaterialResource($material->load('comments'));
    }

    public function addComment(Request $request, SubjectMaterial $material)
    {
        $request->validate([
            'comment' => 'required|string|max:255'
        ]);

        $material->comments()->create([
            'student_id' => Auth::guard('student')->user()->id,
            'comment' => $request->comment
        ]);

        return SubjectMaterialCommentResource::collection($material->comments);
    }

    public function getComments(SubjectMaterial $material)
    {
        return SubjectMaterialCommentResource::collection($material->comments);
    }
}
