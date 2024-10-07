<?php

namespace App\Http\Resources\Professor;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessorEducationResource extends JsonResource
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
            'school' => $this->school,
            'scholarship_s' => $this->scholarship_s->format('Y-m-d'),
            'scholarship_f' => $this->scholarship_f->format('Y-m-d'),
            'degree' => $this->degree,
        ];
    }
}
