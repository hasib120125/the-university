<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class FeatureResource extends JsonResource
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
            'name'=> App::isLocale('en') ? $this->name : $this->name_ko,
            'name_ko'=> $this->name_ko,
            'text'=> App::isLocale('en') ? $this->text : $this->text_ko,
            'text_ko'=> $this->text_ko,
            'status'=> $this->status,
            'image'=> Storage::url($this->image),
        ];
    }
}
