<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectNoteResource extends JsonResource
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
            'lecture' => new LectureResource($this->whenLoaded('lecture')),
            'student' => new StudentResource($this->whenLoaded('student')),
            'time' => gmdate("i:s", (int) $this->time),
            'time_sec' => $this->time,
            'note' => $this->note
        ];
    }
}
