<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function statusName($status)
    {
        switch ($status) {
            case 1:
                return trans('student/form.application.pending');
                break;
            
            case 2:
                return trans('student/form.application.approved');
                break;
            
            case 3:
                return trans('student/form.application.rejected');
                break;
            
            default:
                return '';
                break;
        }
    }

    public function toArray($request)
    {
        return [
            'id'=> $this->id, 
            'student_id'=> $this->student_id,
            'subject'=> $this->subject,
            'status'=> $this->status,
            'status_name'=> $this->statusName($this->status),
            'attachments'=> ApplicationAttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
