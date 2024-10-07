<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExamQuestionResource extends JsonResource
{
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
            'subject_exam_id'=> $this->subject_exam_id,
            'question_type'=> $this->question_type,
            'difficulty'=> $this->difficulty,
            'quater_code'=> $this->quater_code,
            'title'=> $this->title,
            'problem_related_image'=>  $this->problem_related_image ? Storage::url($this->problem_related_image) : '',
            'attachment'=> $this->attachment ? Storage::url($this->attachment) : '',
            'answer'=> $this->when(Auth::guard('admin')->check(), $this->answer),
            'marks'=> $this->marks,
            'mcq1'=> $this->mcq1,
            'mcq2'=> $this->mcq2,
            'mcq3'=> $this->mcq3,
            'mcq4'=> $this->mcq4,
            'mcq5'=> $this->mcq5,
            'student_answer'=> $this->whenLoaded('studentAnswers', function() {
                if(count($this->studentAnswers) > 0){
                    return new LectureExamAnswerResource($this->studentAnswers[0]);
                }
                return null;
            })
        ];
    }
}
