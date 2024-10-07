<?php

namespace App\Http\Resources;

use App\Models\LectureManagementProgress;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LectureManagementResource extends JsonResource
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
            'lecture_id' => $this->lecture_id,
            'lecture_number' => $this->lecture_number,
            'lecture_name' => $this->lecture_name,
            'audio' => route('stream', ['content' => 'audio/mp3', 'path' => $this->audio]),
            'file' => $this->file ? Storage::url($this->file) : '',
            'video_running_time' => $this->video_running_time,
            'thumbs' => $this->when($this->thumbs, Storage::url($this->thumbs)),
            'description' => $this->description,
            'start_period' => $this->start_period->format('Y-m-d'),
            'end_period' => $this->end_period->format('Y-m-d'),
            'duration' => gmdate("i:s", (int) $this->duration). ' min',
            'audio_duration' => gmdate("i:s", (int) $this->audio_duration). ' min',
            'lecture' => new LectureResource($this->lecture),
            'smil' => 'http://'.config('services.media_server.host').':1935/vod/smil:'.$this->smil.'/playlist.m3u8',
            'convert_status' => $this->convert_status,
        ];
    }
}
