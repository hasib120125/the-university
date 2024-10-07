<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PageResource extends JsonResource
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
            'menu_id' => $this->menu_id,
            'menu' => new MenuResource($this->menu),
            'submenu' => new SubMenuResource($this->submenu),
            'sub_id' => $this->sub_id,
            'title' => App::isLocale('en') ? $this->title : $this->title_ko,
            'title_en' => $this->title,
            'title_ko' => $this->title_ko,
            'description' => App::isLocale('en') ? $this->description : $this->description_ko,
            'description_en' => $this->description,
            'description_ko' => $this->description_ko,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'status' => $this->status,
            'can_delete' => $this->can_delete,
        ];
    }
}
