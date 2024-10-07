<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NoticeResource extends JsonResource
{
    public function statusText($value)
    {
        switch ($value) {
            case 1:
                return trans(('admin/form.lecture.active'));
                break;

            case 0:
                return trans(('admin/form.lecture.inactive'));
                break;

            default:
                return '';
                break;
        }
    }

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
            'subject' => $this->subject,
            'category' => $this->category,
            'description' => $this->description,
            'status' => $this->status,
            'status_name' => $this->statusText($this->status),
            'attachment1_original_filename' => $this->attachment1_original_filename ?: basename($this->attachment1),
            'attachment2_original_filename' => $this->attachment2_original_filename ?: basename($this->attachment2),
            'attachment1' => $this->attachment1 ? Storage::url($this->attachment1) : '',
            'attachment2' => $this->attachment2 ? Storage::url($this->attachment2) : '',
        ];
    }
}
