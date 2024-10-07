<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class GalleryResource extends JsonResource
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
            'name'=> App::isLocale('en') ? $this->name_en : $this->name_kr,
            'name_kr'=> $this->name_kr,
            'name_en'=> $this->name_en,
            'description'=> App::isLocale('en') ? $this->description_en : $this->description_kr,
            'description_kr'=> $this->description_kr,
            'description_en'=> $this->description_en,
            'images'=> GalleryImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
