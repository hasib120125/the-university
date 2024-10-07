<?php

namespace App\Http\Resources\Professor;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessorCareerResource extends JsonResource
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
            'professor_id' => $this->professor_id,
            'position' => $this->position,
            'employer' => $this->employer,
            'department' => $this->department,
            'period' => $this->period,
        ];
    }
}
