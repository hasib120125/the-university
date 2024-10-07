<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaithResource extends JsonResource
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
            'student_id'=> $this->student_id,
            'name'=> $this->name,
            'location'=> $this->location,
            'office'=> $this->office,
            'denomination'=> $this->denomination,
            'year_of_faith'=> $this->year_of_faith
        ];
    }
}
