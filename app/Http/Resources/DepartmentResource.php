<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'degree' => $this->degree,
            'subject_type' => $this->whenPivotLoaded('department_subject', function () {
                return $this->pivot->subject_type;
            }),
            'status' => $this->status,
            'status_name' => $this->statusText($this->status),
        ];
    }

    private function statusText($value)
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
}
