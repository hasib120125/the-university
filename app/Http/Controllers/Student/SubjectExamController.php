<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectExamResource;
use App\Models\Subject;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectExam;
use App\Models\SubjectExamAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectExamController extends Controller
{
    public function index(SubjectActiveStudent $subject)
    {
        $query = SubjectExam::query()
                        ->where('subject_id', $subject->subject_id)
                        ->where('status', 1)
                        ->whereDate('start_period','<=', Carbon::today()->startOfDay())
                        ->whereDate('end_period','>=', Carbon::today()->endOfDay())
                        ->with(["currentStudent"])
                        ->where('semester_id', $subject->semester_id)->latest();
        
        return SubjectExamResource::collection(executeQuery($query));
    }

    public function examList(SubjectActiveStudent $subject)
    {
        $query = SubjectExam::query()
                        ->where('subject_id', $subject->subject_id)
                        ->where('status', 1)
                        ->with(["currentStudent"])
                        ->where('semester_id', $subject->semester_id)->latest();
        
        return SubjectExamResource::collection(executeQuery($query));
    }

    public function show(SubjectActiveStudent $subject, SubjectExam $exam)
    {
        $student = Auth::guard('student')->user();
        $examStudent = $exam->students()->where('student_id',$student->id)->first();
        
        if($examStudent){
            if( $examStudent['pivot']['start_time'] && $examStudent['pivot']['end_time']){
                return response()->json(['exist' => true, 'message' => trans('common/message.question.exist')]);
            }
    
            $start = strtotime($examStudent['pivot']['start_time']);
            $end = strtotime(date('H:i:s'));
            $timeTaken = ($end - $start) / 60;
    
            if($timeTaken > $exam->time_limit){
                $exam->students()->where('student_id',$student->id)->update([
                    'end_time' => date('H:i:s'),
                    'updated_at' => Carbon::now()
                ]);
                return response()->json(['exceedTime' => true, 'message' => trans('common/message.question.exceedTime')]);
            }

            return new SubjectExamResource($exam->load('questions', 'currentStudent'));
        }
        
        $exam->students()->attach($student->id, [
            'start_time' => date('H:i:s'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return new SubjectExamResource($exam->load('questions', 'currentStudent'));
    }

    public function update(Request $request, SubjectActiveStudent $subject, SubjectExam $exam)
    {
        $student = Auth::guard('student')->user();
        $examStudent = $exam->students()->where('student_id',$student->id)->first();

        if($examStudent['pivot']['start_time'] && $examStudent['pivot']['end_time']){
            return response()->json(['exist' => true, 'message' => trans('common/message.question.exist')]);
        }

        // $start = strtotime($examStudent['pivot']['start_time']);
        // $end = strtotime(date('H:i:s'));
        // $timeTaken = ($end - $start) / 60;

        $exam->students()->where('student_id',$student->id)->update([
            'end_time' => date('H:i:s'),
            'updated_at' => Carbon::now()
        ]);

        // if($timeTaken > $exam->time_limit){
        //     return response()->json(['exceedTime' => true, 'message' =>  trans('common/message.question.exceedTime')]);
        // }

        $questions = $request->questions;
        $originalQuestion = $exam->questions;
        foreach ($questions as $question) {
            if(isset($question['answer'])){
                $questionAnswer = $originalQuestion->where('id', $question['id'])->first(); 

                $data = [
                    'subject_exam_id'=> $exam->id,
                    'subject_exam_question_id'=> $question['id'],
                    'student_id'=> $student['id'],
                    'answer'=> $question['answer'],
                    'correct'=> in_array($question['question_type'],[1,2]) ? ($question['answer'] == $questionAnswer->answer ? true : false) : null,
                    'score'=> in_array($question['question_type'],[1,2]) ? ($question['answer'] == $questionAnswer->answer ? $questionAnswer->marks : 0) : 0,
                ];

                SubjectExamAnswer::create($data);
            }
        }
        

        return SubjectExamResource::collection(
            executeQuery(
                            SubjectExam::query()->where('subject_id', $subject->subject_id)
                                    ->where('status', 1)
                                    ->whereDate('start_period','<=', Carbon::today())
                                    ->whereDate('end_period','>=', Carbon::today())
                )
        );
    }
    
}
