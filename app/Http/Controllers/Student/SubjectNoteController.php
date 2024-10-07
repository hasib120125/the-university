<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureNoteResource;
use App\Http\Resources\SubjectNoteResource;
use App\Models\Lecture;
use App\Models\LectureNote;
use App\Models\Subject;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SubjectActiveStudent $subject, Request $request)
    {
        $query = $subject->subject->notes()->where('student_id', Auth::user()->id);

        if ($request->lecture && $request->lecture !== '')
            $query->where('lecture_id', $request->lecture);

        if ($request->sort && $request->sort !== '') {
            if ($request->sort == '1')
                $query->orderBy('created_at', 'desc');
            elseif ($request->sort == '2')
                $query->orderBy('created_at');
        }

        return SubjectNoteResource::collection($query->with('lecture')->get());
    }

    public function store(Request $request, SubjectActiveStudent $subject)
    {
        $data = $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'time' => 'required|integer|min:0',
            'note' => 'required',
        ]);

        $data['subject_id'] = $subject->subject_id;
        $data['student_id'] = Auth::guard('student')->user()->id;

        SubjectNote::create($data);

        return SubjectNoteResource::collection($subject->notes()->where('student_id', Auth::user()->id)->with('lecture')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LectureNote  $lectureNote
     * @return \Illuminate\Http\Response
     */
    public function show(LectureNote $lectureNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LectureNote  $lectureNote
     * @return SubjectNoteResource
     */
    public function update(Request $request, Subject $subject, SubjectNote $note)
    {
        $data = $request->validate([
            'note' => 'required',
        ]);

        $note->update($data);

        return new SubjectNoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LectureNote  $lectureNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject, SubjectNote $note)
    {
        $note->delete();
    }
}
