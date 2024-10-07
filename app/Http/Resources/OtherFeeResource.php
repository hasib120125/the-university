<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OtherFeeResource extends JsonResource
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
            'entrance' => $this->entrance,
            'seminar_fees' => $this->seminar_fees,
            'student_union' => $this->student_union,
            'orientation' => $this->orientation,
        ];
    }
}
