<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTuitionFeeResource extends JsonResource
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
            'student' => new StudentResource($this->student),
            'tuition_fee' => $this->tuition_fee,
            'enterance_fee' => $this->enterance_fee,
            'seminar_fee' => $this->seminar_fee,
            'student_union_fee' => $this->student_union_fee,
            'orientation_fee' => $this->orientation_fee,
            'deduction' => $this->deduction,
            'scholarship' => $this->scholarship,
        ];
    }
}
