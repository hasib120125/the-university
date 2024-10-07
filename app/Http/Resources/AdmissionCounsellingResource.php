<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class AdmissionCounsellingResource extends JsonResource
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
            'question_en' => $this->question_en,
            'question_ko' => $this->question_ko,
            'question'=> App::isLocale('en') ?  $this->question_en : $this->question_ko,
            'answer_en' => $this->answer_en,
            'answer_ko' => $this->answer_ko,
            'answer'=> App::isLocale('en') ?  $this->answer_en : $this->answer_ko,
        ];
    }
}
