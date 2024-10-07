<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BulkVideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'original_filename' => $this->original_filename,
            'convert_status' => $this->convert_status,
            'fail' => $this->fail,
            'can_assign' => $this->can_assign,
            'smil' => config('services.media_server.smil').'/vod/smil:'.$this->smil.'/playlist.m3u8',
        ];
    }
}
