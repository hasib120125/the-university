<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\MaterialCommentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LectureMaterialResource extends JsonResource
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
            'lecture_id' => $this->lecture_id,
            'description' => $this->description,
            'attachment1' => $this->attachment1 ? Storage::url($this->attachment1) : '',
            'attachment2' => $this->attachment2 ? Storage::url($this->attachment2) : '',
            'lecture' => new LectureResource($this->whenLoaded('lecture')),
            'comments' => MaterialCommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
