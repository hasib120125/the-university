<?php

namespace App\Http\Resources;

use App\Http\Resources\SemesterResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationOpenResource extends JsonResource
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
            'semester' => new SemesterResource($this->semester),
            'start_date'=> $this->start_date->format('Y-m-d'),
            'end_date'=> $this->end_date->format('Y-m-d')
        ];
    }
}
