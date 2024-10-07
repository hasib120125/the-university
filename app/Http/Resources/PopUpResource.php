<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PopUpResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'title' =>$this->title,
            'top' =>$this->top,
            'left' =>$this->left,
            'content' =>$this->content,
        ];
    }
}
