<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'subject_id'=> $this->subject_id,
            'student_id'=> $this->student_id,
            'attendance'=> $this->attendance,
            'middle'=> $this->middle,
            'ending'=> $this->ending,
            'etc'=> $this->etc,
            'attendance_rate'=> $this->attendance_rate,
            'grade'=> $this->grade,
            'grades'=> $this->grades,
            'subject'=> new SubjectResource($this->subject)
        ];
    }
}
