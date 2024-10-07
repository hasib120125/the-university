<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentGradeResource extends JsonResource
{
    public function seasonName($value)
    {
        switch ($value) {
            case 1:
                return trans('admin/form.semester.season_1');
                break;
            case 2:
                return trans('admin/form.semester.season_2');
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
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject_name,
            'credit' => $this->credit,
            'subject' => new SubjectResource($this->subject),
            'subject_plan' => $this->whenLoaded('subjectPlans', function () {
                foreach ($this->subjectPlans as $subjectPlan) {
                    if ($subjectPlan->semester_id == $this->semester_id) return $subjectPlan;
                }
            }),
            'student_id' => $this->student_id,
            'student_no' => $this->student_no,
            'student' => new StudentResource($this->whenLoaded('student')),
            'semester_id' => $this->semester_id,
            'semester_code' => $this->semester_code,
            'semester' => new SemesterResource($this->whenLoaded('semester')),
            'attendance' => $this->attendance,
            'middle' => $this->middle,
            'ending' => $this->ending,
            'etc' => $this->etc,
            'score' => $this->score,
            'attendance_rate' => $this->attendance_rate,
            'grade' => $this->grade,
            'grades' => $this->grades,
            'semester_year' => $this->semester_year,
            'semester_season' => $this->semester_season,
            'calculated' => $this->calculated,
            'pass' => $this->pass,
            'season_name' => $this->seasonName($this->semester_season),
        ];
    }
}
