<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureQAResource extends JsonResource
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
            'lecture_id'=> $this->lecture_id,
            'lecture_management_id'=> $this->lecture_management_id,
            'student_id'=> $this->student_id,
            'type'=> $this->type,
            'title'=> $this->title,
            'details'=> $this->details,
            'like'=> $this->like,
            'created_at'=> $this->created_at->diffForHumans(),
            'student'=> new StudentResource($this->whenLoaded('student')),
            'management'=> new LectureManagementResource($this->whenLoaded('management')),
            'total_reply'=> $this->replies()->count(),
            'replies'=> LectureQAReplyResource::collection($this->whenLoaded('replies')),
            // 'liked_users'=> $this->liked_users
        ];
    }
}
