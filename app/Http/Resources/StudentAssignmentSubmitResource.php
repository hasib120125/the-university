<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAssignmentSubmitResource extends JsonResource
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
            'id'=> $this->id, 
            'student_id'=> $this->student_id, 
            'student'=> new StudentResource($this->whenLoaded('student')), 
            'subject_assignment_id'=> $this->subject_assignment_id,
            'status'=> $this->status,
            'attachments'=> StudentSubjectAssignmentAttachmentResource::collection($this->whenLoaded('attachments')),
            'admin_action_button_show' => in_array($this->status, [1,2]) ? false : true,
        ];
    }
}
