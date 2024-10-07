<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ApplicationAttachmentResource extends JsonResource
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
            'application_id'=> $this->application_id,
            'file'=> Storage::url($this->file),
            'file_name'=> $this->file_name ?: basename($this->file),
            'application'=> new ApplicationResource($this->whenLoaded('application'))
        ];
    }
}
