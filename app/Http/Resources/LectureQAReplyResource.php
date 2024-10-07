<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureQAReplyResource extends JsonResource
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
            'lecture_qa_id'=> $this->lecture_qa_id,
            'user_id'=> $this->user_id,
            'user_type'=> $this->user_type,
            'reply'=> $this->reply,
            'like'=> $this->like,
            'liked_users'=> $this->liked_users,
            'created_at'=> $this->created_at->diffForHumans(),
            'user' => $this->when($this->user_type == 1, new AdminResource($this->whenLoaded('admin'))),
            'user' => $this->when($this->user_type == 2, new StudentResource($this->whenLoaded('student'))),
        ];
    }
}
