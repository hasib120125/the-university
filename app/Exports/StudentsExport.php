<?php

namespace App\Exports;

use App\Enumeration\StudentStatus;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array{
        $students = Student::where('active', 1)->with('department')->get();
        
        $studentsArray = [];

        foreach ($students as $student) {
            $studentsArray[] = [
                'Name'=> $student->name_hangul,
                'Department'=> $student->department ? $student->department->name : '',
                'Citizenship No'=> $student->citizenship_no,
                'Student No'=> $student->student_no,
                'DOB'=> $student->dob ? $student->dob->format('Y-m-d') : '',
                'Email'=> $student->email,
                'Address'=> $student->address,
                'Mobile'=> $student->mobile,
                'Job Company Name'=> $student->job_company,
                'Job Company Address'=> $student->job_address,
                'Admission Date'=> $student->admission_date ? $student->admission_date->format('Y-m-d') : '',
                'Church Name'=> $student->church_name,
                'Status'=> $this->status($student->status),
            ];
        }

        return [
            $studentsArray
        ];
    }

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

    public function headings(): array
    {
        return [
            'Name',
            'Department',
            'Citizenship No',
            'Student No',
            'DOB',
            'Email',
            'Address',
            'Mobile',
            'Job Company Name',
            'Job Company Address',
            'Admission Date',
            'Church Name',
            'Status',
        ];
    } 
}
