<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurriculumFeeResource extends JsonResource
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
            'semester' => new SemesterResource($this->semester),
            'curriculum' => new DepartmentResource($this->curriculum),
            'grade' => $this->grade,
            'subject_fee' => $this->subject_fee,
            'orientation_fee' => $this->orientation_fee,
            'others_fee' => $this->others_fee,
        ];
    }
}
