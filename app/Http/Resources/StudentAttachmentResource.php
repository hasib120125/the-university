<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentAttachmentResource extends JsonResource
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
            'orginal_name' => $this->orginal_name ?: basename($this->attachment2),
            'attachment' => $this->attachment ? Storage::url($this->attachment) : '',
            'student_id' => $this->student_id,
            'student' => new StudentResource($this->whenLoaded('student')),
        ];
    }
}
