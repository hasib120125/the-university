<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
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
            'customData'=> (object) [
                'id'=> $this->id,
                'title'=> $this->title,
                'title'=> $this->title,
                'type'=> $this->type,
                'description'=> $this->description,
                'date'=> $this->date->format('Y-m-d'),
                'label'=> $this->date->format('F j, Y'),
            ],
            'dates'=> $this->date->format('Y-m-d'),
        ];
    }
}
