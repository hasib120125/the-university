<?php

namespace App\Http\Resources;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\LectureResource;
use App\Http\Resources\Professor\ProfessorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function allDepartmentsName($departments)
    {
        if(count($departments) == 0) return '';
        $departmentsName = '';
        foreach ($departments as $key => $department) {
            if($departmentsName === '') $departmentsName = $department['name'] .'('. $department->pivot->subject_type . ')';
            else $departmentsName = $departmentsName .', '. $department['name'] .'('. $department->pivot->subject_type . ')' ;
        }
        return $departmentsName;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'credit' => $this->credit,
            'status' => $this->status,
            'departments' => DepartmentResource::collection($this->departments),
            'allDepartmentsName' => $this->allDepartmentsName($this->departments),
            'professor_id' => $this->professor_id,
            'max_student' => $this->max_student,
            'professor' => new ProfessorResource($this->whenLoaded('professor')),
            'lectures' => LectureResource::collection($this->whenLoaded('lectures'))
        ];
    }
}
