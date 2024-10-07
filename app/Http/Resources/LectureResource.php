<?php

namespace App\Http\Resources;

use App\Http\Resources\Professor\ProfessorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LectureResource extends JsonResource
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

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subject_id' => $this->subject_id,
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'professor_id' => $this->professor_id,
            'professor' => new ProfessorResource($this->whenLoaded('professor')),
            'semester_id' => $this->semester_id,
            'semester' => new SemesterResource($this->whenLoaded('semester')),
            'bulk_video_id' => $this->bulk_video_id ?? '',
            'bulkVideo' => new BulkVideoResource($this->whenLoaded('bulkVideo')),
            'bulk_audio_id' => $this->bulk_audio_id ?? '',
            'bulkAudio' => new BulkAudioResource($this->whenLoaded('bulkAudio')),
            'bulk_subtitle_id' => $this->bulk_subtitle_id ?? '',
            'bulkSubtitle' => new BulkSubtitleResource($this->whenLoaded('bulkSubtitle')),
            'start_period' => $this->start_period->format('Y-m-d'),
            'end_period' => $this->end_period->format('Y-m-d'),
            'description' => $this->description,
            'subtitle_file' => $this->subtitle_file,
            'subtitle_label' => $this->subtitle_label,
            // 'subtitle_file_formatted' => $this->when($this->subtitle_file, Storage::url($this->subtitle_file)),
            'subtitle_file_formatted' => $this->when($this->subtitle_file, asset('/storage/' . $this->subtitle_file)),
            'audio_file' =>  $this->audio_file ? route('stream', ['content' => 'audio/mp3', 'path' => $this->audio_file]) : null,
            'audio_duration' => gmdate("i:s", (int) $this->audio_duration) . ' min',
            'original_video_file' => $this->file ? Storage::url($this->original_video_file) : '',
            'thumbs' => $this->when($this->thumbs, Storage::url($this->thumbs)),
            'audio_thumbs' => $this->when($this->audio_thumbs, $this->audio_thumbs),
            'duration' => gmdate("i:s", (int) $this->duration) . ' min',
            'smil' => config('services.media_server.smil') . '/vod/smil:' . $this->smil . '/playlist.m3u8',
            'convert_status' => $this->convert_status,
            'status' => $this->status,
            'status_name' => $this->statusText($this->status),
            'progress' => $this->whenLoaded('progress', new LectureProgressResource($this->progress->first())),
        ];
    }
}
