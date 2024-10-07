<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $maxSeekTime = 0;

        if ($this->completed == 1) {
            $maxSeekTime = $this->current_content_type == 'a' ? $this->audio_total_time : $this->video_total_time;
        } else {
            $maxSeekTime = $this->current_content_type == 'a' ? $this->audio_current_time : $this->video_current_time;
        }

        return [
            'audio_current_time' => $this->audio_current_time,
            'video_current_time' => $this->video_current_time,
            'audio_total_time' => $this->audio_total_time,
            'video_total_time' => $this->video_total_time,
            'audio_progress_percentage' => $this->audio_progress_percentage,
            'video_progress_percentage' => $this->video_progress_percentage,
            'current_content_type' => $this->current_content_type,
            'progress_percentage' => $this->current_content_type == 'a' ? $this->audio_progress_percentage : $this->video_progress_percentage,
            'current_time' => $this->current_content_type == 'a' ? $this->audio_current_time : $this->video_current_time,
            'max_seek_time' => $maxSeekTime,
            'completed' => $this->completed,
            'late' => $this->late,
        ];
    }
}
