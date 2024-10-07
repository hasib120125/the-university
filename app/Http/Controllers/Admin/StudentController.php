<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\StudentStatus;
use App\Exports\GradeExport;
use App\Exports\StudentsExport;
use App\Models\Grade;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\StudentAttachmentResource;
use App\Http\Resources\StudentGradeResource;
use App\Http\Resources\SubjectActiveStudentResource;
use App\Imports\StudentImport;
use App\Models\CreditTransaction;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\LectureProgress;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\StudentAttachment;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectPlan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends Controller
{
    public function index()
    {
        return StudentResource::collection(executeQuery(Student::query()->where('active', 1)));
    }

    public function active()
    {
        return StudentResource::collection(executeQuery(Student::query()->where('active', 1)));
    }

    public function inActive()
    {
        return StudentResource::collection(executeQuery(Student::query()->where('active', 0)));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_no' => 'nullable|string|max:20',
            'name_hangul' => 'required|string',
            'name_chinese' => 'required|string',
            'name_english' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email|unique:students',
            'password' => 'nullable|min:6',
            'address' => 'nullable|string',
            'department_id' => 'required|integer',
            'semester_id' => 'nullable|integer',
            'citizenship_no' => 'nullable|string',
            'dob' => 'nullable|date',
            'mobile' => 'nullable|string',
            'last_education_start' => 'nullable|date',
            'last_education_end' => 'nullable|date|after_or_equal:last_education_start',
            'last_school_name' => 'nullable|string',
            'graduate_plan' => 'nullable|string',
            'last_education_department' => 'nullable|string',
            'last_education_special' => 'nullable|string',
            'motive' => 'nullable|string',
            'job_company' => 'nullable|string',
            'job_position' => 'nullable|string',
            'job_address' => 'nullable|string',
            'remark' => 'nullable|string',
            'grade' => 'nullable|string',
            'status' => 'nullable',
            'degree_number' => 'nullable|string',
            'withdrawal_date' => 'nullable|date',
            'admission_date' => 'nullable|date',
            'graduation_date' => 'nullable|date|after_or_equal:admission_date',
            'admit_status' => 'nullable|boolean',
            'bible_exam' => 'nullable',
            'point_value' => 'nullable',
            'leave_start_date' => 'required_if:status,2,3|nullable|date',
            'leave_end_date' => 'required_if:status,2",3|nullable|date|after_or_equal:leave_start_date',
            'active' => 'boolean',
            'church_name' => 'nullable|string'
        ], [
            'leave_start_date.required_if' => 'leave start date field is required',
            'leave_end_date.required_if' => 'leave end date field is required',
        ]);

        $departmentCode = Department::find($request->department_id)->code;
        $setting = Setting::with('semester')->first();
        $studentCount = Student::where('semester_id', $setting->current_semester_id)->withTrashed()->count();
        $student_no = $setting->semester->year . $setting->semester->season . $departmentCode . str_pad($studentCount + 1, 3, '0', STR_PAD_LEFT);

        $student = new Student();
        $student->student_no = $student_no;
        $student->name_hangul = $request->name_hangul;
        $student->name_chinese = $request->name_chinese;
        $student->name_english = $request->name_english;
        $student->photo = $request->file('photo') ? $request->file('photo')->store('students') : null;
        $student->email = $request->email;
        $student->password = $request->dob ? bcrypt(date("ymd", strtotime($request->dob))) : bcrypt('123456');
        $student->address = $request->address;
        $student->department_id = $request->department_id;
        $student->semester_id = $request->semester_id;
        $student->citizenship_no = $request->citizenship_no;
        $student->dob = date('Y-m-d', strtotime($request->dob));
        $student->leave_start_date = date('Y-m-d', strtotime($request->leave_start_date));
        $student->leave_end_date = date('Y-m-d', strtotime($request->leave_end_date));
        $student->mobile = $request->mobile;
        $student->last_education_start = date('Y-m-d', strtotime($request->last_education_start));
        $student->last_education_end = date('Y-m-d', strtotime($request->last_education_end));
        $student->last_school_name = $request->last_school_name;
        $student->graduate_plan = $request->graduate_plan;
        $student->last_education_department = $request->last_education_department;
        $student->last_education_special = $request->last_education_special;
        $student->motive = $request->motive;
        $student->job_company = $request->job_company;
        $student->job_position = $request->job_position ?? '';
        $student->job_address = $request->job_address;
        $student->remark = $request->remark;
        $student->grade = $request->grade;
        $student->status = $request->status;
        $student->degree_number = $request->degree_number;
        $student->withdrawal_date = date('Y-m-d', strtotime($request->withdrawal_date));
        $student->admission_date = date('Y-m-d', strtotime($request->admission_date));
        $student->graduation_date = date('Y-m-d', strtotime($request->graduation_date));
        $student->admit_status = $request->admit_status;
        $student->bible_exam = $request->bible_exam;
        $student->point_value = $request->point_value;
        $student->church_name = $request->church_name;
        $student->active = $request->active;
        $student->save();

        $attachments = $request->attachmentFiles ? explode(',', $request->attachmentFiles) : null;
        $originaAttachments = $request->attachmentFiles ? explode(',', $request->originaAttachments) : null;

        if ($attachments) {
            foreach ($attachments as $key => $attachment) {
                $file = str_replace("temp/", "", $attachment);
                Storage::move($attachment, 'student_attachments/' . $file);
                $filePath = 'student_attachments/' . $file;

                $student->attachments()->create([
                    'orginal_name' => $originaAttachments[$key],
                    'attachment' => $filePath,
                ]);
            }
        }

        return new StudentResource($student);
    }

    public function show(Student $student)
    {
        return new StudentResource($student->load('faiths'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name_hangul' => 'required|string',
            'name_chinese' => 'required|string',
            'name_english' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'password' => 'nullable|min:6',
            'address' => 'required|string',
            'department_id' => 'required|integer',
            'semester_id' => 'nullable|integer',
            'student_no' => 'nullable|string|unique:students,student_no,' . $student->id,
            // 'dob' => 'required|date',
            // 'mobile' => 'required|string',
            // 'last_education_start' => 'required|date',
            // 'last_education_end' => 'required|date|after_or_equal:last_education_start',
            // 'last_school_name' => 'required|string',
            // 'graduate_plan' => 'required|string',
            // 'last_education_department' => 'required|string',
            // 'last_education_special' => 'required|string',
            // 'motive' => 'required|string',
            // 'job_company' => 'required|string',
            // 'job_position' => 'required|string',
            // 'job_address' => 'required|string',
            'remark' => 'nullable|string',
            'status' => 'required',
            'church_name' => 'nullable|string',
            'grade' => 'nullable|string',
            // 'degree_number' => 'required|string',
            'withdrawal_date' => 'nullable|date',
            // 'admission_date' => 'required|date',
            'graduation_date' => 'nullable|date|after_or_equal:admission_date',
            // 'admit_status' => 'required|boolean',
            // 'bible_exam' => 'required|boolean',
            'active' => 'required|boolean',
            'leave_start_date' => 'required_if:status,2,3|nullable|date',
            'leave_end_date' => 'required_if:status,2,3|nullable|date|after_or_equal:leave_start_date',
        ], [
            'semester_id.required' => 'The Semester field is required',
            'leave_start_date.required_if' => 'leave start date field is required',
            'leave_end_date.required_if' => 'leave end date field is required',
        ]);

        $attachments = $request->attachmentFiles ? explode(',', $request->attachmentFiles) : null;
        $originaAttachments = $request->attachmentFiles ? explode(',', $request->originaAttachments) : null;

        if ($attachments) {
            foreach ($attachments as $key => $attachment) {
                $file = str_replace("temp/", "", $attachment);
                Storage::move($attachment, 'student_attachments/' . $file);
                $filePath = 'student_attachments/' . $file;

                $student->attachments()->create([
                    'orginal_name' => $originaAttachments[$key],
                    'attachment' => $filePath,
                ]);
            }
        }

        if ($request->password) {
            $student->password = bcrypt($request->password);
        }

        if (!$request->student_no && $request->active) {
            $departmentCode = Department::find($request->department_id)->code;

            $studentCount = Student::where('created_at', '>=', Carbon::now()->startOfYear()->startOfDay())->where('created_at', '<=', Carbon::now()->endOfYear()->endOfDay())->withTrashed()->count();

            $student_no = date("Y") . (date('m') <= 6 ? 1 : 2) . $departmentCode . str_pad($studentCount + 1, 3, '0', STR_PAD_LEFT);

            $student->student_no = $student_no;
        } else {
            $student->student_no = $request->student_no;
        }

        $student->name_hangul = $request->name_hangul;
        $student->name_chinese = $request->name_chinese;
        $student->name_english = $request->name_english;
        $student->photo = $request->file('photo') ? $request->file('photo')->store('students') : $student->photo;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->department_id = $request->department_id;
        $student->semester_id = $request->semester_id;
        $student->citizenship_no = $request->citizenship_no;
        $student->dob = $request->dob;
        $student->grade = $request->grade;
        $student->leave_start_date = $request->leave_start_date;
        $student->leave_end_date = $request->leave_end_date;
        $student->mobile = $request->mobile;
        $student->last_education_start = $request->last_education_start;
        $student->last_education_end = $request->last_education_end;
        $student->last_school_name = $request->last_school_name;
        $student->graduate_plan = $request->graduate_plan;
        $student->last_education_department = $request->last_education_department;
        $student->last_education_special = $request->last_education_special;
        $student->motive = $request->motive ?? '';
        $student->job_company = $request->job_company;
        $student->job_position = $request->job_position ?? '';
        $student->job_address = $request->job_address;
        $student->remark = $request->remark;
        $student->church_name = $request->church_name;
        $student->status = $request->status;
        $student->degree_number = $request->degree_number;
        $student->withdrawal_date = $request->withdrawal_date;
        $student->admission_date = $request->admission_date;
        $student->graduation_date = $request->graduation_date;
        $student->admit_status = $request->admit_status;
        $student->bible_exam = $request->bible_exam;
        $student->point_value = $request->point_value;
        $student->active = $request->active;
        $student->save();

        return new StudentResource($student);
    }

    public function destroy(Student $student)
    {
        $student->email = $student->email . random_int(100000, 999999);
        $student->save();

        if (Storage::exists($student->photo))
            Storage::delete($student->photo);

        $student->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function allStudents()
    {
        return StudentResource::collection(executeQuery(Student::query()->with('grades')));
    }

    public function studentResult(Student $student)
    {
        $query = StudentGrade::with('subjectPlans')->where('student_id', $student->id);

        //        $query->whereHas('semester', function (Builder $q) use($student){
        //            $q->where('semesters.id', $student->semester_id);
        //        });

        $semesterWiseGrades = $query->with('semester')->orderBy('semester_code')->get()->groupBy('semester_code');
        $formattedGrades = [];
        foreach ($semesterWiseGrades as $semester_code => $semesterWiseGrade) {
            $formattedGrades[$semester_code] = StudentGradeResource::collection($semesterWiseGrade);
        }
        return response()->json(['success' => true, 'data' => count($formattedGrades) > 0 ? $formattedGrades : null]);
    }

    public function activate(Student $student)
    {
        if (!$student->student_no) {
            $departmentCode = Department::find($student->department_id)->code;

            $studentCount = Student::where('created_at', '>=', Carbon::now()->startOfYear()->startOfDay())->where('created_at', '<=', Carbon::now()->endOfYear()->endOfDay())->withTrashed()->count();

            $student_no = date("Y") . (date('m') <= 6 ? 1 : 2) . $departmentCode . str_pad($studentCount + 1, 3, '0', STR_PAD_LEFT);

            $student->student_no = $student_no;
        }

        $student->active = 1;
        $student->save();
        return new StudentResource($student);
    }

    public function excelImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls.,xlsx'
        ]);

        $studentImport = new StudentImport;
        Excel::import($studentImport, request()->file('file'));

        return response()->json(['data' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'data' => 'required|array|min:1',
            // 'data.*.email' => 'required|email|min:1|max:190',
            'data.*.student_id' => 'required|max:190',
        ]);

        $importDatas = $request['data'];
        foreach ($importDatas as $importData) {
            $student = Student::where('email', $importData['email'] ?? '')->orWhere('student_no', $importData['student_id'])->first();
            if (!$student) $student = new Student();

            $student->student_no = $importData['student_id'];
            $student->name_hangul = $importData['name'];
            $student->name_chinese = $importData['name'];
            $student->name_english = $importData['name'];
            $student->email = $importData['email'] ?? '';
            $student->address = $importData['address'] ?? '';
            $student->mobile = $importData['phone_no'];
            $student->motive = $importData['motive'] ?? '';
            $student->job_company = $importData['job_compnay_name'] ?? '';
            $student->job_position = $importData['job'] ?? '';
            $student->job_address = $importData['job_address'] ?? '';
            $student->password = bcrypt(123456);

            $department = Department::where('name', $importData['department'])->first();
            if (!$department) {
                $degree = ['Bachelor', 'Master'];
                $key = array_rand($degree);
                $department = Department::create([
                    'name' => $importData['department'],
                    'code' => rand(100, 999),
                    'degree' => $degree[$key]
                ]);
            }

            $student->department_id = $department->id;
            $student->zip_code = $importData['zip_code'] ?? '';
            // $student->status = $importData['status'];
            $student->active = 1;
            $student->save();
        }
        return response()->json(['success' => true, 'message' => trans('admin/form.student.import_done')]);
    }

    public function deptSubjectDetails(Student $student)
    {
        $deptSubTypes = DB::table('department_subject')->where('department_id', $student->department_id)->whereNotNull('subject_type')->get()->groupBy('subject_type');
        return $deptSubTypes;
    }

    public function giveCredit(Student $student, Request $request)
    {
        $request->validate([
            'credit' => 'required|min:1',
        ]);

        $payment = Payment::create([
            'payment_id' => 'ICS' . random_int(100000, 999999),
            'amount' => 0,
            'note' => '관리자 지불',
            'type' => 1,
            'status' => 1,
            'student_id' => $student->id,
            'attachment' => null,
        ]);

        $transaction = new CreditTransaction();
        $transaction->payment_id = $payment->id;
        $transaction->student_id = $payment->student_id;
        $transaction->type = $payment->type;
        $transaction->credit = $request->credit - $student->available_credit;
        $transaction->per_credit_rate = 0;
        $transaction->save();

        $student->available_credit = $request->credit;
        $student->save();

        return response()->json(['success' => true, 'message' => trans('admin/label.credit_give_message')]);
    }

    public function removeSubject(Request $request)
    {
        $subject = Subject::find($request->subject_id);
        $student = Student::find($request->student_id);

        $payment = Payment::create([
            'payment_id' => 'ICS' . random_int(100000, 999999),
            'amount' => 0,
            'note' => '신용 반환',
            'type' => 1,
            'status' => 1,
            'student_id' => $student->id,
            'attachment' => null,
        ]);

        $transaction = new CreditTransaction();
        $transaction->payment_id = $payment->id;
        $transaction->student_id = $payment->student_id;
        $transaction->type = $payment->type;
        $transaction->credit = $subject->credit;
        $transaction->per_credit_rate = 0;
        $transaction->save();

        $student->increment('available_credit', $transaction->credit);

        $subjectLectures = Subject::where('id', $request->subject_id)->with(['lectures' => function ($q) use ($request) {
            $q->where('semester_id', $request->semester_id);
        }])->first();

        $lectureIds = $subjectLectures->lectures->pluck('id')->toArray();
        LectureProgress::whereIn('lecture_id', $lectureIds)->where('student_id', $request->student_id)->delete();
        StudentGrade::where(['subject_id' => $request->subject_id, 'student_id' => $request->student_id, 'semester_id' => $request->semester_id])->delete();
        SubjectActiveStudent::where(['subject_id' => $request->subject_id, 'student_id' => $request->student_id, 'semester_id' => $request->semester_id])->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function subjectAttendance(Request $request)
    {
        $data = Lecture::where('subject_id', $request->subject_id)->where('semester_id', $request->semester_id)->with(['lectureProgress' => function ($q) use ($request) {
            $q->where('student_id', $request->student_id);
        }])->get();

        return $data;
    }

    public function subjectAttendanceStore(Request $request)
    {
        // note lecture_progress_status -> 1['Completed'], 2['Absent], 3['Late']
        $lecture_ids = [];
        $others = $request->others;

        foreach ($request->lectures as $lecture) {
            $lecture_ids[] = $lecture['lecture_id'];

            if ($lecture['lecture_progress_status'] != null) {
                $lectureProgress = LectureProgress::find($lecture['lecture_progress_id']);

                if (!$lectureProgress) $lectureProgress = new LectureProgress();

                $lectureProgress->student_id = $lecture['student_id'];
                $lectureProgress->lecture_id = $lecture['lecture_id'];
                $lectureProgress->completed = $lecture['lecture_progress_status'] == 1 ? 1 : ($lecture['lecture_progress_status'] == 3 ? 1 : 0);
                $lectureProgress->late = $lecture['lecture_progress_status'] == 3 ? 1 : 0;
                $lectureProgress->current_content_type = $lecture['current_content_type'] ?? 'v';
                $lectureProgress->save();
            }
        }

        $subjectPlan = SubjectPlan::where(['subject_id' => $others['subject_id'], 'semester_id' => $others['semester_id']])->first();

        if ($subjectPlan) {
            $lectures = Lecture::whereIn('id', $lecture_ids)
                ->with([
                    'lectureProgress' => function ($query) use ($others) {
                        $query->where('lecture_progress.student_id', $others['student_id']);
                    }
                ])
                ->get();

            $attendanceData = $this->calculateAttendance($lectures);

            $attendanceMark = 0;

            if ($lectures->count() > 28) {
                if ($attendanceData['absent'] >= 12) {
                    $attendanceMark = 0;
                } else {
                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.33, 0.16);
                }
            } elseif ($lectures->count() > 14) {
                if ($attendanceData['absent'] >= 8) {
                    $attendanceMark = 0;
                } else {
                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.5, 0.25);
                }
            } else {
                if ($attendanceData['absent'] >= 4) {
                    $attendanceMark = 0;
                } else {
                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 1, 0.5);
                }
            }

            StudentGrade::where(['student_id' => $others['student_id'], 'semester_id' => $others['semester_id'], 'subject_id' => $others['subject_id']])
                ->update([
                    'attendance' => $attendanceMark,
                    'attendance_rate' => (($attendanceData['present'] + ($attendanceData['late'] * .5)) / $lectures->count()) * 100,
                ]);
        }

        return response()->json(['success' => true, 'message' => trans('admin/label.attendance_update')]);
    }

    public function calculateLateAbsentMark($data, $lateDeduct, $absentDeduct)
    {
        $lateMark = $data['late'] * $lateDeduct;
        $absentMark = $data['absent'] * $absentDeduct;

        return $lateMark + $absentMark;
    }

    public function calculateAttendance($lectures = null)
    {
        $absent = 0;
        $late = 0;
        $present = 0;
        if ($lectures) {
            foreach ($lectures as $lecture) {
                if ($lecture->lectureProgress->count() > 0 && $lecture->lectureProgress[0]) {
                    if ($lecture->lectureProgress[0]['completed'] && $lecture->lectureProgress[0]['late']) {
                        $late++;
                    } else if ($lecture->lectureProgress[0]['completed']) {
                        $present++;
                    } else {
                        $absent++;
                    }
                }
            }
        }

        return ['absent' => $absent, 'present' => $present, 'late' => $late];
    }

    public function subjects(Student $student)
    {
        return SubjectActiveStudentResource::collection(executeQuery($student->activeSubjects()
            ->with(['subject'])->whereHas('subject')));
    }

    public function attachments(Student $student)
    {
        return StudentAttachmentResource::collection(executeQuery($student->attachments()));
    }

    public function attachmentDestroy(StudentAttachment $attachment)
    {
        $attachment->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function exportGrade(Request $request)
    {
        $setting = Setting::first();

        $grade = Grade::orderBy('point', 'asc')->get();

        $query = StudentGrade::query()->where('semester_id', '!=', $setting->current_semester_id)->with('student', 'student.department');

        if ($request->semester_id) {
            $query->where('semester_id', $request->semester_id);
        }

        $studentGradeData = $query->get()->groupBy('student_id');

        return $studentGradeData->count();
        $formattedDatas = [];
        //        학과	,이름,	학번,	학년,	상태,	총점평균,	평점평균,	등급,	신청학점,	취득학점,
        foreach ($studentGradeData as $studentGrade) {
            $passedSubjects = $studentGrade->where('grades', '>', 0);
            $passedTotalSubject = $passedSubjects->count();
            $totalMark = $passedSubjects->sum('score');
            $grades = $passedSubjects->sum('grades');
            $earnCredits = $passedSubjects->sum('credit');
            $applyCredit = $studentGrade->sum('credit');

            $totalGrades = 0;

            foreach ($passedSubjects as $sGrade) {
                $totalGrades += ($sGrade->credit * $sGrade->grades);
            }

            $cgpa = $earnCredits > 0 ? number_format((float)($totalGrades / $earnCredits), 2, '.', '') : '0';

            $calculatedGrade = $this->calculateGrade($cgpa, $grade);

            $formattedDatas[] = [
                'department' => $studentGrade[0]->student && $studentGrade[0]->student->department ? $studentGrade[0]->student->department->name : '',
                'name' => $studentGrade[0]->student ? $studentGrade[0]->student->name_hangul : '',
                'studentId' => $studentGrade[0]->student ? $studentGrade[0]->student->student_no : '',
                'year' => $this->calculateYear($studentGrade),
                'status' => $studentGrade[0]->student && $studentGrade[0]->student->status ? StudentStatus::$STASTUS_TEXT[$studentGrade[0]->student->status] : StudentStatus::$STASTUS_TEXT[1],
                'totalMark' => $passedTotalSubject > 0 ? floor($totalMark / $passedTotalSubject) : '0',
                'cgpa' => $cgpa > 0 ? $cgpa : '0',
                'grade' => $calculatedGrade ? $calculatedGrade : 'Fail',
                'applyCredit' => $applyCredit > 0 ? $applyCredit : '0',
                'earnCredit' => $earnCredits > 0 ? $earnCredits : '0',
            ];
        }

        return Excel::download(new GradeExport($formattedDatas), 'grade.xlsx');
    }

    public function calculateYear($data)
    {
        $semStart = str_split($data->min('semester_code'), 4);
        $semEnd = str_split($data->max('semester_code'), 4);

        $studyTotalSemester = 0;

        for ($i = $semStart[0]; $i <= $semEnd[0]; $i++) {
            if ($i == $semEnd[0] && $semEnd[1] == 1) {
                $studyTotalSemester += 1;
            } else if ($i == $semEnd[0] && $semEnd[1] == 2) {
                $studyTotalSemester += 2;
            } else if ($i == $semStart[0] && $semStart[1] == 2) {
                $studyTotalSemester += 1;
            } else if ($i == $semStart[0] && $semStart[1] == 1) {
                $studyTotalSemester += 2;
            }
        }

        return floor($studyTotalSemester / 2);
    }

    public function calculateGrade($cgpa, $grade)
    {
        $gradeLength = $grade->count() - 1;

        $result = null;

        for ($i = $gradeLength; $gradeLength >= 0; $i--) {
            if ($i < 0 || $i - 1 < 0) {
                if ($cgpa <= $grade[0]['point']) {
                    return $grade[0]['grade'];
                }
            } else if ($gradeLength == $i) {
                if ($cgpa >= $grade[$i]['point']) {
                    return $grade[$i]['grade'];
                }
            } else {
                if ($cgpa >= $grade[$i]['point'] && $cgpa <= ($grade[$i + 1]['point'] - 0.01)) {
                    return $grade[$i]['grade'];
                }
            }
        }

        return $result;
    }
}
