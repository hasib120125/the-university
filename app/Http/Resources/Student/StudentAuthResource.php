<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\Professor\ProfessorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentAuthResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'student',
            'name' => $this->name_english,
            'email' => $this->email,
            'token' => $this->token,
            'photo' => $this->photo ? Storage::url($this->photo) : asset('images/profile_avatar.jpg'),
        ];
    }
}
