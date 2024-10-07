<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectExamResource;
use App\Http\Resources\Student\StudentResource;
use App\Models\ExamQuestion;
use App\Models\Subject;
use App\Models\SubjectExam;
use App\Models\SubjectExamAnswer;
use App\Models\Student;
use Illuminate\Http\Request;

class SubjectExamController extends Controller
{
    public function index(Subject $subject, Request $request)
    {
        $query = $subject->exams();

        if ($request->semester_id)
            $query->where('semester_id', $request->semester_id);

        return SubjectExamResource::collection(executeQuery($query));
    }

    public function store(Request $request, Subject $subject)
    {
        $data = $request->validate([
                'title' => 'required|string',
                'semester_id' => 'required|integer|exists:semesters,id',
                'start_period'=> 'required|date',
                'end_period'=> 'required|date|after_or_equal:start_period',
                'time_limit'=> 'required|integer',
                'exam_type'=> 'required|integer|between:1,3',

                'questions.*.question_type' => 'required|integer',
                'questions.*.difficulty' => 'required|integer|between:1,5',
                'questions.*.quater_code' => 'required|integer',
                'questions.*.title' => 'required|string',
                'questions.*.problem_related_image'=> 'nullable|file',
                'questions.*.attachment'=> 'nullable|file',
                'questions.*.answer'=> 'required|string',
                'questions.*.mcq1'=> 'required_if:question_type,==,2|nullable|string',
                'questions.*.mcq2'=> 'required_if:question_type,==,2|nullable|string',
                'questions.*.mcq3'=> 'nullable|string',
                'questions.*.mcq4'=> 'nullable|string',
                'questions.*.mcq5'=> 'nullable|string'
            ],[
                'questions.*.question_type.required' => 'Question type field is required',
                'questions.*.question_type.integer' => 'Question type field must be integer',
                'questions.*.difficulty.required' => 'Difficulty field is required',
                'questions.*.difficulty.integer' => 'Difficulty field must be integer',
                'questions.*.difficulty.between' => 'Difficulty field must be between 1-5',
                'questions.*.quater_code.required' => 'Quater code field is required',
                'questions.*.quater_code.integer' => 'Quater code field must be integer',
                'questions.*.title.required' => 'Title field is required',
                'questions.*.title.string' => 'Title field must be string',
                'questions.*.problem_related_image.file' => 'Problem related image must be a file',
                'questions.*.attachment.file' => 'Attachment must be a file',
                'questions.*.answer.required' => 'Answer field is required',
                'questions.*.answer.string' => 'Answer field must be string',
                'questions.*.mcq1.string' => 'mcq1 field must be string',
                'questions.*.mcq2.string' => 'mcq2 field must be string',
                'questions.*.mcq3.string' => 'mcq3 field must be string',
                'questions.*.mcq4.string' => 'mcq4 field must be string',
                'questions.*.mcq5.string' => 'mcq5 field must be string'
            ]
        );

        $exam = $subject->exams()->create($data);

        if(count($request->questions)){
            $questionsData = [];
            foreach ($request->questions as $question) {
                if($question['title']){
                    $questionsData[] = [
                        'question_type' => $question['question_type'],
                        'difficulty' => $question['difficulty'],
                        'quater_code' => $question['quater_code'],
                        'title' => $question['title'],
                        'problem_related_image' => $question['problem_related_image'],
                        'attachment' => $question['attachment'],
                        'answer' => $question['answer'],
                        'marks' => $question['marks'],
                        'mcq1' => $question['mcq1'],
                        'mcq2' => $question['mcq2'],
                        'mcq3' => $question['mcq3'],
                        'mcq4' => $question['mcq4'],
                        'mcq5' => $question['mcq5']
                    ];
                }
            }

            $exam->questions()->createMany($questionsData);
        }

        return new SubjectExamResource($exam);
    }

    public function show(Subject $subject, SubjectExam $exam)
    {
        return new SubjectExamResource($exam->load('questions'));
    }

    public function update(Request $request, Subject $subject, SubjectExam $exam)
    {

        $request->validate([
                'title' => 'required|string',
                'start_period'=> 'required|date',
                'end_period'=> 'required|date|after_or_equal:start_period',
                'time_limit'=> 'required|integer',
                'exam_type'=> 'required|integer|between:1,3',

                'questions.*.question_type' => 'required|integer',
                'questions.*.difficulty' => 'required|integer|between:1,5',
                'questions.*.quater_code' => 'required|integer',
                'questions.*.title' => 'required|string',
                'questions.*.problem_related_image'=> 'nullable|file',
                'questions.*.attachment'=> 'nullable|file',
                'questions.*.answer'=> 'required|string',
                'questions.*.mcq1'=> 'required_if:question_type,==,2|nullable|string',
                'questions.*.mcq2'=> 'required_if:question_type,==,2|nullable|string',
                'questions.*.mcq3'=> 'nullable|string',
                'questions.*.mcq4'=> 'nullable|string',
                'questions.*.mcq5'=> 'nullable|string'
            ],[
                'questions.*.question_type.required' => 'Question type field is required',
                'questions.*.question_type.integer' => 'Question type field must be integer',
                'questions.*.difficulty.required' => 'Difficulty field is required',
                'questions.*.difficulty.integer' => 'Difficulty field must be integer',
                'questions.*.difficulty.between' => 'Difficulty field must be between 1-5',
                'questions.*.quater_code.required' => 'Quater code field is required',
                'questions.*.quater_code.integer' => 'Quater code field must be integer',
                'questions.*.title.required' => 'Title field is required',
                'questions.*.title.string' => 'Title field must be string',
                'questions.*.problem_related_image.file' => 'Problem related image must be a file',
                'questions.*.attachment.file' => 'Attachment must be a file',
                'questions.*.answer.required' => 'Answer field is required',
                'questions.*.answer.string' => 'Answer field must be string',
                'questions.*.mcq1.string' => 'mcq1 field must be string',
                'questions.*.mcq2.string' => 'mcq2 field must be string',
                'questions.*.mcq3.string' => 'mcq3 field must be string',
                'questions.*.mcq4.string' => 'mcq4 field must be string',
                'questions.*.mcq5.string' => 'mcq5 field must be string'
            ]
        );

        $exam->title = $request->title;
        $exam->start_period = $request->start_period;
        $exam->end_period = $request->end_period;
        $exam->time_limit = $request->time_limit;
        $exam->exam_type = $request->exam_type;

        $exam->save();
        
        if(count($request->questions)){
            $questionsData = [];
            foreach ($request->questions as $question) {
                if(isset($question['id'])){
                    $mainQuestion = ExamQuestion::find($question['id']);
                    $mainQuestion->question_type = $question['question_type'];
                    $mainQuestion->difficulty = $question['difficulty'];
                    $mainQuestion->quater_code = $question['quater_code'];
                    $mainQuestion->title = $question['title'];
                    $mainQuestion->problem_related_image = $question['problem_related_image'];
                    $mainQuestion->attachment = $question['attachment'];
                    $mainQuestion->answer = $question['answer'];
                    $mainQuestion->marks = $question['marks'];
                    $mainQuestion->mcq1 = $question['mcq1'];
                    $mainQuestion->mcq2 = $question['mcq2'];
                    $mainQuestion->mcq3 = $question['mcq3'];
                    $mainQuestion->mcq4 = $question['mcq4'];
                    $mainQuestion->mcq5 = $question['mcq5'];
                    $mainQuestion->save();
                }else{
                    $questionsData[] = [
                        'question_type' => $question['question_type'],
                        'difficulty' => $question['difficulty'],
                        'quater_code' => $question['quater_code'],
                        'title' => $question['title'],
                        'problem_related_image' => $question['problem_related_image'],
                        'attachment' => $question['attachment'],
                        'answer' => $question['answer'],
                        'marks' => $question['marks'],
                        'mcq1' => $question['mcq1'],
                        'mcq2' => $question['mcq2'],
                        'mcq3' => $question['mcq3'],
                        'mcq4' => $question['mcq4'],
                        'mcq5' => $question['mcq5']
                    ];
                }
            }

            if(count($request->removeQuestions)){
                foreach ($request->removeQuestions as $removeQuestion) {
                    if(isset($removeQuestion['id'])){
                        $deleteQuestion = ExamQuestion::find($removeQuestion['id']);
                        if($deleteQuestion)
                            $deleteQuestion->delete(); 
                    }
                }
            }

            $exam->questions()->createMany($questionsData);
        }

        return new SubjectExamResource($exam);
    }

    public function destroy(Subject $subject, SubjectExam $exam)
    {
        $exam->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function students(SubjectExam $exam)
    {
        $query = $exam->students()->with(['answeredQuestions'=>function ($query) use($exam){
                                    $query->where('subject_exam_id', $exam->id);
                                }]);
                                
        return StudentResource::collection(executeQuery($query));
    }

    public function studentExam($exam_id, Student $student)
    {
        $examData = SubjectExam::where('id', $exam_id)->with(['questions.studentAnswers' => function ($query) use($student){
            $query->where('student_id', $student->id);
        }])->first();

        return new SubjectExamResource($examData);
    }

    public function examAnswerStore(Request $request,SubjectExam $exam, Student $student)
    {
        $questions = $request->questions;
        
        foreach ($questions as $question) { 
            if($question['student_answer']){
                SubjectExamAnswer::where('id',$question['student_answer']['id'])->update([
                    'correct'=> $question['student_answer']['correct'],
                    'score'=> $question['student_answer']['correct'] ? ($question['student_answer']['score'] ?? $question['marks']) : 0
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Stored Successfully!']);
    }
}
