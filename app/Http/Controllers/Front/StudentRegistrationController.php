<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\Student\StudentResource;
use App\Models\Department;
use App\Models\RegistrationOpen;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentRegistrationController extends Controller
{
    public function departments()
    {
        return DepartmentResource::collection(Department::where('status', 1)->get());
    }

    public function registrationOpen()
    {
        $registrationOpen = RegistrationOpen::whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())->first();

        return response()->json(['open' => $registrationOpen ? true : false]);
    }

    public function register(Request $request)
    {
        //        $registrationOpen = RegistrationOpen::whereDate('start_date', '<=' , Carbon::now())
        //                                             ->whereDate('end_date', '>=' , Carbon::now())->first();
        //
        //        if(!$registrationOpen){
        //            return response()->json(['success' => false, 'message' => 'Registration time expired.'], 410);
        //        }

        $request->merge(['faiths' => json_decode($request->faiths, true)]);
        $data = $request->validate(
            [
                'name_hangul' => 'required|string',
                'name_chinese' => 'required|string',
                'name_english' => 'required|string',
                'citizenship_no' => 'required|string',
                'age' => 'required|numeric',
                'gender' => 'required|string',
                'mobile' => 'required|string',
                // 'phone' => 'required|string',
                'email' => 'required|email|unique:students',
                'dob' => 'required|date',
                'address' => 'required|string',
                'photo' => 'required|file',
                'password' => 'required|min:6',
                'last_education_start' => 'nullable|date',
                'last_education_end' => 'nullable|date|after_or_equal:last_education_start',
                'last_school_name' => 'nullable|string',
                'last_education_department' => 'nullable|string',
                'last_education_special' => 'nullable|string',
                'motive' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
                'job_company' => 'nullable|string',
                'job_position' => 'nullable|string',
                'job_address' => 'nullable|string',
                'admit_status' => 'nullable|boolean',
                'confention_faith_file' => 'nullable|file',
                'study_plan' => 'nullable|file',
                'theological_dissertation_file' => 'nullable|file',
                'faiths.*.name' => 'nullable|string',
                'faiths.*.location' => 'nullable|string',
                'faiths.*.office' => 'nullable|string',
                'faiths.*.denomination' => 'nullable|string',
                'faiths.*.year_of_faith' => 'nullable|string',
            ],
            [
                'name_hangul.required' => '이름(한글)을 입력해주세요.',
                'name_chinese.required' => '이름(한문)을 입력해주세요.',
                'name_english.required' => '이름(영문)을 입력해주세요.',
                'citizenship_no.required' => '주민등록번호를 입력해주세요.',
                'age.required' => '나이를 입력해주세요.',
                'gender.required' => '성별을 선택해주세요.',
                'mobile.required' => '핸드폰번호를 입력해주세요.',
                'email.required' => '이메일을 입력해주세요.',
                'dob.required' => '생년월일을 입력해주세요.',
                'address.required' => '주소를 입력해주세요.',
                'photo.required' => '사진은 필수입니다.',
                'faiths.*.name.required' => 'name field is required',
                'faiths.*.location.required' => 'location field is required',
                'faiths.*.office.required' => 'office field is required',
                'faiths.*.denomination.required' => 'denomination field is required',
                'faiths.*.year_of_faith.required' => 'year of faith field is required'
            ]
        );

        $setting = Setting::with('semester')->first();

        // $student_no = date("Y") . (date('m') <= 6 ? 1 : 2) . $departmentCode . str_pad( $studentCount + 1 , 3, '0', STR_PAD_LEFT);

        $data['photo'] = $request->file('photo') ? $request->file('photo')->store('students') : null;

        $data['confention_faith_file'] = $request->file('confention_faith_file') ? $request->file('confention_faith_file')->store('students') : null;
        $data['study_plan'] =  $request->file('study_plan') ? $request->file('study_plan')->store('students') : '';
        $data['theological_dissertation_file'] = $request->file('theological_dissertation_file') ? $request->file('theological_dissertation_file')->store('students') : '';

        // $data['student_no'] = $student_no;
        $dob = $request->dob;
        $data['password'] = bcrypt(date("ymd", strtotime($dob)));
        $data['semester_id'] = $setting->current_semester_id;
        $data['active'] = 0;

        $student = Student::create($data);
        if ($student->confention_faith_file) {
            $this->studentAttachment($student, 'confention_faith_file', $request);
        }

        if ($student->study_plan) {
            $this->studentAttachment($student, 'study_plan', $request);
        }

        if ($student->theological_dissertation_file) {
            $this->studentAttachment($student, 'theological_dissertation_file', $request);
        }

        foreach ($request->faiths as $faith) {
            if ($faith['name'] && $faith['name'] != '') {
                $student->faiths()->create([
                    'name' => $faith['name'],
                    'location' => $faith['location'],
                    'office' => $faith['office'],
                    'denomination' => $faith['denomination'],
                    'year_of_faith' => $faith['year_of_faith']
                ]);
            }
        }

        return new StudentResource($student);
    }

    public function studentAttachment($student, $key, $request)
    {
        $student->attachments()->create([
            'orginal_name' => $request->file($key) ? $request->file($key)->getClientOriginalName() : null,
            'attachment' => $request->file($key)->store('student_attachments'),
        ]);
    }
}
