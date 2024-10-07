<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class NewsResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => App::isLocale('en') ? $this->title_en : $this->title_ko,
            'title_en'=> $this->title_en,
            'title_ko'=> $this->title_ko,
            'content_en' => $this->when(request()->get('content_en') == 'true', $this->content_en),
            'content_ko' => $this->when(request()->get('content_ko') == 'true', $this->content_ko),
            'content' => $this->when(request()->get('content') == 'true', App::isLocale('en') ? $this->content_en : $this->content_ko),
            'summary_en'=> $this->summary_en,
            'summary_ko'=> $this->summary_ko,
            'summary' => App::isLocale('en') ? $this->summary_en : $this->summary_ko,
            'cover'=> Storage::url($this->cover),
            'thumbs' => Storage::url($this->thumbs),
            'created_at' => $this->created_at->format('j F, Y H:i A'),
            'created_at_raw' => $this->created_at,
        ];
    }
}
