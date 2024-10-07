<?php

namespace App\Http\Resources\Student;

use App\Enumeration\StudentStatus;
use Illuminate\Support\Facades\App;
use App\Http\Resources\GradeResource;
use App\Http\Resources\LectureResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SemesterResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\FaithResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LectureExamAnswerResource;
use App\Http\Resources\StudentAttachmentResource;

class StudentResource extends JsonResource
{
    public function status($value)
    {
        $valueText = '';
        switch ($value) {
            case StudentStatus::$ATTENDING:
                $valueText = __('student/form.profile.status_text.attending');
                break;

            case StudentStatus::$LEAVE:
                $valueText = __('student/form.profile.status_text.leave_of_absence');
                break;

            case StudentStatus::$ARMY:
                $valueText = __('student/form.profile.status_text.military_leave');
                break;

            case StudentStatus::$FINISH:
                $valueText = __('student/form.profile.status_text.completion');
                break;

            case StudentStatus::$GRADUATED:
                $valueText = __('student/form.profile.status_text.graduated');
                break;

            case StudentStatus::$GRADUATION_PLAN:
                $valueText = __('student/form.profile.status_text.graduation_plan');
                break;

            case StudentStatus::$WEEDING:
                $valueText = __('student/form.profile.status_text.weeding');
                break;

            case StudentStatus::$DROPOUT:
                $valueText = __('student/form.profile.status_text.drop_out');
                break;

            default:
                # code...
                break;
        }

        return $valueText;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_no' => $this->student_no,
            'available_credit' => $this->available_credit,
            'due_payments' => $this->due_payments,
            'name_hangul' => $this->name_hangul,
            'name_chinese' => $this->name_chinese,
            'name_english' => $this->name_english,
            'name' => $this->name_hangul,
            'photo' => $this->photo ? Storage::url($this->photo) : asset('images/profile_avatar.jpg'),
            'temp_photo' => $this->photo ? explode('/', $this->photo)[1] : null,
            'confention_faith_file' =>  Storage::url($this->confention_faith_file),
            'study_plan' =>  Storage::url($this->study_plan),
            'theological_dissertation_file' =>  Storage::url($this->theological_dissertation_file),
            'email' => $this->email,
            'address' => $this->address,
            'department_id' => $this->department_id,
            'semester_id' => $this->semester_id,
            'department' => new DepartmentResource($this->department),
            'semester' => new SemesterResource($this->semester),
            'citizenship_no' => $this->citizenship_no,
            'dob' => $this->dob ? $this->dob->format('Y-m-d') : '',
            'dob_formatted' => $this->dob ? $this->dob->format('j F, Y') : '',
            'mobile' => $this->mobile,
            'last_education_start' => $this->last_education_start ? $this->last_education_start->format('Y-m-d') : null,
            'last_education_end' => $this->last_education_end ? $this->last_education_end->format('Y-m-d') : null,
            'last_school_name' => $this->last_school_name,
            'graduate_plan' => $this->graduate_plan,
            'last_education_department' => $this->last_education_department,
            'last_education_special' => $this->last_education_special,
            'motive' => $this->motive,
            'pendingLecture' => LectureResource::collection($this->whenLoaded('pendingLecture')),
            'activeLecture' => LectureResource::collection($this->whenLoaded('activeLecture')),
            'job_company' => $this->job_company,
            'job_position' => $this->job_position,
            'job_address' => $this->job_address,
            'remark' => $this->remark,
            'grade' => $this->grade,
            'status' => (string) $this->status,
            'status_text' => $this->status($this->status),
            'degree_number' => $this->degree_number,
            'withdrawal_date' => $this->withdrawal_date ? $this->withdrawal_date->format('Y-m-d') : null,
            'admission_date' => $this->admission_date ? $this->admission_date->format('Y-m-d') : null,
            'graduation_date' => $this->graduation_date ? $this->graduation_date->format('Y-m-d') : null,
            'admit_status' => $this->admit_status,
            'bible_exam' => $this->bible_exam,
            'point_value' => $this->point_value,
            'leave_start_date' => $this->leave_start_date ? $this->leave_start_date->format('Y-m-d') : '',
            'leave_end_date' => $this->leave_end_date ? $this->leave_end_date->format('Y-m-d') : '',
            'created_at' => $this->created_at,
            'active' => $this->active,
            'grades' => GradeResource::collection($this->grades),
            'show_transcript' => $this->when($this->grades->count() > 0 && $this->active, 1),
            'assignment_submission_status' => $this->whenPivotLoaded('student_subject_assignment', function () {
                return $this->pivot->status;
            }),
            'attachment1' => $this->whenPivotLoaded('student_subject_assignment', function () {
                return $this->pivot->attachment1 ? Storage::url($this->pivot->attachment1) : '';
            }),
            'attachment2' => $this->whenPivotLoaded('student_subject_assignment', function () {
                return $this->pivot->attachment2 ? Storage::url($this->pivot->attachment2) : '';
            }),
            'attachment1_original_filename' => $this->whenPivotLoaded('student_subject_assignment', function () {
                return $this->pivot->attachment1_original_filename ?: basename($this->pivot->attachment1);
            }),
            'attachment2_original_filename' => $this->whenPivotLoaded('student_subject_assignment', function () {
                return $this->pivot->attachment2_original_filename ?: basename($this->pivot->attachment2);
            }),
            'answered_questions' => $this->whenLoaded('answeredQuestions', function () {
                return LectureExamAnswerResource::collection($this->answeredQuestions);
            }),
            'church_name' => $this->church_name,
            'attachments' => StudentAttachmentResource::collection($this->whenLoaded('attachments')),
            'originaAttachments' => [],
            'faiths' => FaithResource::collection($this->whenLoaded('faiths')),
        ];
    }
}
