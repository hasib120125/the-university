<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class MenuResource extends JsonResource
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
            'name' => App::isLocale('en') ? $this->name : $this->name_ko,
            'name_en' => $this->name,
            'name_ko' => $this->name_ko,
            'slug' => $this->slug,
            'sub_menus' => SubMenuResource::collection($this->submenus->sortBy('sort')),
            'sort' => $this->sort,
            'status' => $this->status,
            'can_delete' => $this->can_delete,
        ];
    }
}
