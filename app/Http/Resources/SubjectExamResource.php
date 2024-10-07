<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SubjectExamResource extends JsonResource
{
    public function remainingTime()
    {
        if($this->currentStudent->count()){
            $currentStudent = $this->currentStudent->first();
            $start = strtotime($currentStudent['pivot']['start_time']);
            $currentTime = strtotime(date('H:i:s'));
            $timeTaken = ($currentTime - $start) / 60;

            $remainingTime = $this->time_limit - $timeTaken;

            return $remainingTime * 60;
        }

        return $this->time_limit * 60;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_id'=> $this->subject_id,
            'semseter_id'=> $this->semseter_id,
            'title'=> $this->title,
            'start_period'=> $this->start_period->format('Y-m-d'),
            'end_period'=> $this->end_period->format('Y-m-d'),
            'time_limit'=> $this->time_limit,
            'exam_type'=> $this->exam_type,
            'status'=> $this->status,
            'subject'=> new SubjectResource($this->subject),
            'questions' => ExamQuestionResource::collection($this->whenLoaded('questions')),
            'remainingTime' => $this->whenLoaded('currentStudent', function() {
                return $this->remainingTime();
            }),
            'submission_status' => $this->whenLoaded('currentStudent', function() {
                if($this->currentStudent->count() && $this->currentStudent->first()->pivot->end_time){
                    return true;
                }
                return false;
            }),
            'submission_status_message' => $this->whenLoaded('currentStudent', function() {
                if($this->currentStudent->count() && $this->currentStudent->first()->pivot->end_time){
                    return trans('student/form.exam.submitted');
                }
                return trans('student/form.exam.not_submitted');
            }),
            'student_exam_score' => $this->whenLoaded('currentStudent', function() {
                if(count($this->currentStudent)){
                    $currentStudent = $this->currentStudent->first();
                    $score = $currentStudent->answeredQuestions->where('subject_exam_id', $this->id)->sum('score');

                    if($score > 0){
                        return $score.' '.trans('student/form.exam.marks');
                    }

                    return $score.' '.trans('student/form.exam.mark');
                }

                return trans('student/form.exam.not_attend');
            })
        ];
    }
}
