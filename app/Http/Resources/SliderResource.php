<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SliderResource extends JsonResource
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
            'heading' => $this->heading == 'null' ? null : $this->heading ,
            'text' => $this->text == 'null' ? null : $this->text ,
            'url' => $this->url == 'null' ? null : $this->url ,
            'image' => Storage::url($this->image),
        ];
    }
}
