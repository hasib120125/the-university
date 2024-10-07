<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class SubjectMaterialCommentResource extends JsonResource
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
            'avatar' => $this->student->photo ? Storage::url($this->student->photo) : asset('images/profile_avatar.jpg'),
            'name' => App::isLocale('en') ?  $this->student->name_english : $this->student->name_hangul,
            'comment' => $this->comment,
            'reply' => $this->reply,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
