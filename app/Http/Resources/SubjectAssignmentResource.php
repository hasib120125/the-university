<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubjectAssignmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_id' => $this->subject_id,
            'semester_id' => $this->semester_id,
            'assignment_title' => $this->assignment_title,
            'start_period'=> $this->start_period->format('Y-m-d'),
            'end_period'=> $this->end_period->format('Y-m-d'),
            'task_type'=> $this->task_type,
            'end_open'=> $this->end_open,
            'description' => $this->description,
            'attachment1' => $this->attachment1 ? Storage::url($this->attachment1) : '',
            'attachment2' => $this->attachment2 ? Storage::url($this->attachment2) : '',
            'attachment1_original_filename' => $this->attachment1_original_filename ?: basename($this->attachment1),
            'attachment2_original_filename' => $this->attachment2_original_filename ?: basename($this->attachment2),
        ];
    }
}
