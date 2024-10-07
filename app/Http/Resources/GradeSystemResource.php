<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeSystemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => number_format($this->from, 2, '.', ','),
            'to' => number_format($this->to, 2, '.', ','),
            'grade' => $this->grade,
            'point' => number_format($this->point, 2, '.', ',')
        ];
    }
}
