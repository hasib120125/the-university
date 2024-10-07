<?php

namespace App\Http\Resources;

use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
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
            case 3:
                return trans('admin/form.semester.season_3');
                break;
            case 4:
                return trans('admin/form.semester.season_4');
                break;
        }
    }

    public function name($year, $season)
    {
        switch ($season) {
            case 1:
                return $year . ' - ' . trans('admin/form.semester.season_1');
                break;
            case 2:
                return $year . '-' . trans('admin/form.semester.season_2');
                break;
            case 3:
                return $year . '-' . trans('admin/form.semester.season_3');
                break;
            case 4:
                return $year . '-' . trans('admin/form.semester.season_4');
                break;
        }
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'semester_code' => $this->semester_code,
            'year' => $this->year,
            'season' => $this->season,
            'start_period' => $this->start_period ? $this->start_period->format('Y-m-d') : null,
            'end_period' => $this->end_period ? $this->end_period->format('Y-m-d') : null,
            'last_subject_cancel_date' => $this->last_subject_cancel_date ? $this->last_subject_cancel_date->format('Y-m-d') : null,
            'grade_period' => $this->grade_period ? $this->grade_period->format('Y-m-d') : null,
            'season_name' => $this->seasonName($this->season),
            'name' => $this->name($this->year, $this->season),
            'students' => StudentResource::collection($this->whenLoaded('students')),
        ];
    }
}
