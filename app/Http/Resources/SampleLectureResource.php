<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SampleLectureResource extends JsonResource
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
            'video' => $this->video ? Storage::url($this->video) : null,
            'thumbs' => $this->thumbs ? Storage::url($this->thumbs) : null,
            'sort' => $this->sort,
        ];
    }
}
