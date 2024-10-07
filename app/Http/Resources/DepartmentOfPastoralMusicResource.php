<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DepartmentOfPastoralMusicResource extends JsonResource
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
            'title_en' => $this->title_en,
            'title_ko' => $this->title_ko,
            'title'=> App::isLocale('en') ?  $this->title_en : $this->title_ko,
            'content_en' => $this->content_en,
            'content_ko' => $this->content_ko,
            'content'=> App::isLocale('en') ?  $this->content_en : $this->content_ko,
        ];
    }
}
