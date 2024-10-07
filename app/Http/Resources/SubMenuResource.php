<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SubMenuResource extends JsonResource
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
            'menu_id' => $this->menu_id,
            'slug' => $this->slug,
            'sort' => $this->sort,
            'status' => $this->status,
            'can_delete' => $this->can_delete,
            'route' => $this->menu ? '/'. $this->menu->slug. '/'. $this->slug : $this->slug
        ];
    }
}
