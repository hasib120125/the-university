<?php

namespace App\Http\Resources;

use App\Http\Resources\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Professor\ProfessorResource;

class LectureApplyResource extends JsonResource
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
            'subject' => new SubjectResource($this->subject),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'start_period' => $this->start_period->format('Y-m-d'),
            'end_period' => $this->end_period->format('Y-m-d'),
            'professor' => new ProfessorResource($this->professor)
        ];
    }
}
