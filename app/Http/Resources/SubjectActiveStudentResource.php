<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectActiveStudentResource extends JsonResource
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
            'subject_id'=> $this->subject_id, 
            'subject'=> new SubjectResource($this->whenLoaded('subject')),
            'student_id'=> $this->student_id, 
            'student'=> new StudentResource($this->whenLoaded('student')),
            'semester_id'=> $this->semester_id,
            'semester'=> new SemesterResource($this->whenLoaded('semester')),
            'deleteAble'=> $this->whenLoaded('subject', function() {
                $startDate = $this->semester->last_subject_cancel_date;
                $now = Carbon::now();
                return $now->lt($startDate);
            }),
        ];
    }
}
