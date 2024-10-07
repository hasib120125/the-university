<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubjectNoticeResource extends JsonResource
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
            'title' => $this->title,
            'semester_id' => $this->semester_id,
            'subject_id' => $this->subject_id,
            'description' => $this->description,
            'attachment1_original_filename' => $this->attachment1_original_filename ?: basename($this->attachment1),
            'attachment2_original_filename' => $this->attachment2_original_filename ?: basename($this->attachment2),
            'attachment1' => $this->attachment1 ? Storage::url($this->attachment1) : '',
            'attachment2' => $this->attachment2 ? Storage::url($this->attachment2) : '',
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'comments' => SubjectNoticeCommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
