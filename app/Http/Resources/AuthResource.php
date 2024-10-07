<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AuthResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->type === 'admin' ? $this->name : $this->name_hangul,
            'email' => $this->email,
            'token' => $this->token,
            'photo' => $this->photo ? Storage::url($this->photo) : asset('images/profile_avatar.jpg'),
        ];
    }
}
