<?php

namespace App\Http\Resources;

use App\Models\SubjectPlanTopic;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectPlanResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'semester_id' => $this->semester_id,
            'semester' => new SemesterResource($this->whenLoaded('semester')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'subject_plan_topics' => SubjectPlanTopicResource::collection($this->whenLoaded('subjectPlanTopics')),
            'subject_outline' => $this->subject_outline,
            'textbook' => $this->textbook,
            'reference_book' => $this->reference_book,
            'evaluation_standard' => $this->evaluation_standard,
            'attendance' => $this->attendance,
            'middle' => $this->middle,
            'ending' => $this->ending,
            'etc' => $this->etc,
            'attendance_mark' => $this->attendance_mark,
            'middle_mark' => $this->middle_mark,
            'ending_mark' => $this->ending_mark,
            'etc_mark' => $this->etc_mark,
        ];
    }
}
