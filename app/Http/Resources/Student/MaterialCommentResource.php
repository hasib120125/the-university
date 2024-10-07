<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class MaterialCommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->student->photo ? Storage::url($this->student->photo) : asset('images/profile_avatar.jpg'),
            'name' => $this->student->name_hangul,
            'comment' => $this->comment,
            'reply' => $this->reply,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
