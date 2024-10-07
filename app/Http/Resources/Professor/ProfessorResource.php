<?php

namespace App\Http\Resources\Professor;

use App\Http\Resources\CustomSubjectResource;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ProfessorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_hangul' => $this->name_hangul,
            'name_chinese' => $this->name_chinese,
            'name_english' => $this->name_english,
            'name'=> $this->name_hangul,
            'email' => $this->email,
            'dob' => $this->dob ? $this->dob->format('Y-m-d') : null ,
            'photo' => $this->photo ? Storage::url($this->photo) : asset('images/profile_avatar.jpg'),
            'address' => $this->address,
            'department' => new DepartmentResource($this->department),
            'custom_subject_id' => $this->custom_subject_id,
            'customSubject' => new CustomSubjectResource($this->whenLoaded('customSubject')),
            'subject' => $this->subject,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'status' => $this->status,
            'professor_no' => $this->professor_no,
            'temp_photo' => $this->photo ? explode('/',$this->photo)[1] : null,
            'details' => $this->details,
            'details_image' => $this->details_image ? Storage::url($this->details_image) : null,
            'temp_details_image' => $this->details_image ? explode('/',$this->details_image)[1] : null,
        ];
    }
}
