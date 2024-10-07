<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureExamAnswerResource extends JsonResource
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
            'id'=> $this->id,
            'lecture_exam_id'=> $this->lecture_exam_id,
            'lecture_exam_question_id'=> $this->lecture_exam_question_id,
            'student_id'=> $this->student_id,
            'answer'=> $this->answer,
            'correct'=> $this->correct,
            'score'=> $this->score
        ];
    }
}
