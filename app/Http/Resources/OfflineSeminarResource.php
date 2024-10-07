<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OfflineSeminarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_en' => $this->title_en,
            'title_ko' => $this->title_ko,
            'title'=> App::isLocale('en') ?  $this->title_en : $this->title_ko,
            'content_en' => $this->when(request()->get('content_en') == 'true', $this->content_en),
            'content_ko' => $this->when(request()->get('content_ko') == 'true', $this->content_ko),
            'content' => $this->when(request()->get('content') == 'true', App::isLocale('en') ? $this->content_en : $this->content_ko),
            'preview_image' => $this->preview_image ? Storage::url($this->preview_image) : null
        ];
    }
}
