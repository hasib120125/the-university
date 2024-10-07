<?php

namespace App\Http\Controllers\Student;

use App\Models\Semester;
use App\Models\Setting;
use App\Models\Notice;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\StudentGrade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubjectNotice;
use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\SubjectResource;
use App\Models\SubjcetCreditTransaction;
use App\Http\Resources\SubjectNoticeResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\StudentGradeResource;
use App\Models\Calendar;
use App\Models\SubjectActiveStudent;

class ProfileController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        return new StudentResource($student);
    }

    public function update(Request $request)
    {
        $student = Auth::guard('student')->user();
        $request->validate([
            'address' => 'required|string',
            'mobile' => 'required|string',
            'password' => 'nullable|string',
        ]);

        if ($request->password) {
            $student->password = bcrypt($request->password);
        }

        $student->address = $request->address;
        $student->mobile = $request->mobile;
        $student->save();

        return new StudentResource($student);
    }

    public function subjectApply(Request $request)
    {
        $request->validate([
            'subject_id' => 'required'
        ]);

        $student = Auth::guard('student')->user();
        $subject = Subject::find($request->subject_id);
        $setting = Setting::first();

        if ($subject->max_student > 0 && StudentGrade::where(['subject_id' => $subject->id, 'semester_id' => $setting->current_semester_id])->count() >= $subject->max_student)
            return response()->json(['error' => 'subject_full', 'message' => trans('common/message.subject_full')]);

        if (!$setting->current_semester_id)
            return response()->json(['error' => 'low_credit', 'message' => 'No current semester running for this subject.']);

        if ($subject->credit > $student->available_credit)
            return response()->json(['error' => 'low_credit', 'message' => 'You don\'t have sufficient credit to apply this subject.']);

        SubjectActiveStudent::create([
            'semester_id' => $setting->current_semester_id,
            'subject_id' => $request->subject_id,
            'student_id' => $student->id,
        ]);

        $semester = Semester::find($setting->current_semester_id);

        StudentGrade::create([
            'subject_id' => $request->subject_id,
            'subject_name' => $subject->name,
            'credit' => $subject->credit,
            'student_id' => $student->id,
            'student_no' => $student->student_no,
            'semester_id' => $setting->current_semester_id,
            'semester_code' => $semester->semester_code,
            'semester_year' => $semester->year,
            'semester_season' => $semester->season,
        ]);

        SubjcetCreditTransaction::create([
            'subject_id' => $request->subject_id,
            'student_id' => $student->id,
            'credit' => $subject->credit,
        ]);

        $student->available_credit = $student->available_credit - $subject->credit;
        $student->save();

        return response()->json(['success' => true, 'message' => 'Applied successfully.']);
    }

    public function subjects()
    {
        $setting = Setting::first();
        $student = Auth::guard('student')->user();
        $subjectIds = $student->activeSubjects()->where('semester_id', $setting->current_semester_id)->pluck('subject_id')->toArray();

        return SubjectResource::collection(executeQuery(Subject::query()->whereNotIn('id', $subjectIds)->where('status', 1)));
    }

    public function administrationNotices()
    {
        $setting = Setting::with('semester')->latest()->first();
        $semester = $setting->semester;

        return NoticeResource::collection(executeQuery(
            Notice::query()
                ->where('status', 1)
                // ->where('created_at', '>=', Carbon::parse($semester->start_period)->startOfDay())
                // ->where('created_at', '<=', Carbon::parse($semester->end_period)->startOfDay())
                ->latest()
                ->whereIn('category', ['Student', 'All'])
        ));
    }

    public function administrationNoticeShow(Notice $notice)
    {
        return new NoticeResource($notice);
    }

    public function __subjectNotices()
    {
        $activeSubjects = Auth::guard('student')->user()->activeSubjects()->get();
        $setting = Setting::latest()->first();
        return SubjectNoticeResource::collection(executeQuery(SubjectNotice::query()->latest()->with('subject')->whereIn('subject_id', $activeSubjects->pluck('subject_id')->toArray())
            ->whereIn('semester_id', $activeSubjects->pluck('semester_id')->toArray())->where('semester_id', $setting->current_semester_id)));
    }

    public function subjectNotices()
    {
        $setting = Setting::latest()->first();
        $activeSubjects = Auth::guard('student')->user()->activeSubjects()->where('semester_id', $setting->current_semester_id)->get();
        return SubjectNoticeResource::collection(executeQuery(
            SubjectNotice::query()
                ->latest()
                ->with('subject')
                ->whereIn('subject_id', $activeSubjects->pluck('subject_id')->toArray())
                ->whereIn('semester_id', $activeSubjects->pluck('semester_id')->toArray())
                ->where('semester_id', $setting->current_semester_id)
        ));
    }

    public function subjectNoticeShow(SubjectNotice $notice)
    {
        return new SubjectNoticeResource($notice);
    }

    public function result()
    {
        $student = Auth::guard('student')->user();
        //$semesterWiseGrades = StudentGrade::with('subjectPlans','semester')->where('student_id', $student->id)->whereHas('semester')->get()->groupBy('semester_code');
        $semesterWiseGrades = StudentGrade::with('subjectPlans', 'semester')->where('student_id', $student->id)->orderBy('semester_code')->get()->groupBy('semester_code');
        $formattedGrades = [];
        foreach ($semesterWiseGrades as $semester_code => $semesterWiseGrade) {
            $formattedGrades[$semester_code] = StudentGradeResource::collection($semesterWiseGrade);
        }
        return response()->json(['success' => true, 'data' => count($formattedGrades) > 0 ? $formattedGrades : null]);
    }

    public function calendars()
    {
        return CalendarResource::collection(executeQuery(Calendar::query()->where('type', 'Student')));
    }
}
