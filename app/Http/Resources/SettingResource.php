<?php

namespace App\Http\Resources;

use App\Http\Resources\SemesterResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SettingResource extends JsonResource
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
            'credit_rate' => $this->credit_rate,
            'current_semester_id' => new SemesterResource($this->semester),
            'home_video' => $this->home_video ? Storage::url($this->home_video) : null,
            'university_name' => $this->university_name,
            'university_address' => $this->university_address,
            'phone_number' => $this->phone_number,
            'audio_image' => $this->audio_image ? Storage::url($this->audio_image) : null
        ];
    }
}
