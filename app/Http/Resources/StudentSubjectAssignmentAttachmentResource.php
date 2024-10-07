<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentSubjectAssignmentAttachmentResource extends JsonResource
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
            'student_assignment_submit_id' => $this->student_assignment_submit_id,
            'file_name' => $this->file_name ?: basename($this->file),
            'file' => $this->file ? Storage::url($this->file) : '',
        ];
    }
}
