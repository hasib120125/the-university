<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionResource;
use App\Models\LectureExam;
use App\Models\LectureExamQuestion;
use Illuminate\Http\Request;

class LectureExamQuestionController extends Controller
{
    public function index(LectureExam $lectureExam)
    {
        return ExamQuestionResource::collection(executeQuery($lectureExam->questions()));
    }

    public function questionStatistics($lectureExam)
    {
        $lectureExam = LectureExam::find($lectureExam);
        return response()->json([
            'totalQuestion'=> $lectureExam->number_of_question,
            'added'=> $lectureExam->questions()->count()
        ]);
    }

    public function store(Request $request, LectureExam $lectureExam)
    {
        $data = $request->validate([
            'question_type' => 'required|integer',
            'difficulty' => 'required|integer|between:1,5',
            'quater_code' => 'required|integer',
            'title' => 'required|string',
            'problem_related_image'=> 'nullable|file',
            'attachment'=> 'nullable|file',
            'answer'=> 'required|string',
            'mcq1'=> 'required_if:question_type,==,2|nullable|string',
            'mcq2'=> 'required_if:question_type,==,2|nullable|string',
            'mcq3'=> 'nullable|string',
            'mcq4'=> 'nullable|string',
            'mcq5'=> 'nullable|string'
        ]);

        $data['problem_related_image'] = $request->file('problem_related_image') ? $request->file('problem_related_image')->store('question_attachments') : null;
        $data['attachment'] = $request->file('attachment') ? $request->file('attachment')->store('question_attachments') : null;

        return new ExamQuestionResource($lectureExam->questions()->create($data));
    }

    public function show(LectureExam $lectureExam, LectureExamQuestion $question)
    {
        return new ExamQuestionResource($question);
    }

    public function update(Request $request, LectureExam $lectureExam, LectureExamQuestion $question)
    {
        $request->validate([
            'question_type' => 'required|integer',
            'difficulty' => 'required|integer|between:1,5',
            'quater_code' => 'required|integer',
            'exam_title' => 'required|string',
            'problem_related_image'=> 'nullable|file',
            'attachment'=> 'nullable|file',
            'answer'=> 'required|string',
            'mcq1'=> 'required_if:question_type,==,2|nullable|string',
            'mcq2'=> 'required_if:question_type,==,2|nullable|string',
            'mcq3'=> 'nullable|string',
            'mcq4'=> 'nullable|string',
            'mcq5'=> 'nullable|string'
        ]);

        $problem_related_image = $request->file('problem_related_image') ? $request->file('problem_related_image')->store('question_attachments') : null;
        $attachment = $request->file('attachment') ? $request->file('attachment')->store('question_attachments') : null;

        $question->question_type = $request->question_type;
        $question->difficulty = $request->difficulty;
        $question->quater_code = $request->quater_code;
        $question->exam_title = $request->exam_title;
        $question->problem_related_image = $problem_related_image;
        $question->attachment = $attachment;
        $question->answer = $request->answer;
        $question->mcq1 = $request->mcq1;
        $question->mcq2 = $request->mcq2;
        $question->mcq3 = $request->mcq3;
        $question->mcq4 = $request->mcq4;
        $question->mcq5 = $request->mcq5;

        $question->save();

        return new ExamQuestionResource($question);
    }

    public function destroy(LectureExam $lectureExam, LectureExamQuestion $question)
    {
        $question->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
