<?php

namespace App\Http\Resources;

use App\Models\SubjectMaterialComment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubjectMaterialResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'semester_id' => $this->semester_id,
            'description' => $this->description,
            'attachment1_original_filename' => $this->attachment1_original_filename ?: basename($this->attachment1),
            'attachment2_original_filename' => $this->attachment2_original_filename ?: basename($this->attachment2),
            'attachment1' => $this->attachment1 ? Storage::url($this->attachment1) : '',
            'attachment2' => $this->attachment2 ?  Storage::url($this->attachment2) : '',
            'comments' => SubjectMaterialCommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
