<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\LectureResource;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\Professor\ProfessorEducationResource;
use App\Http\Resources\Professor\ProfessorResource;
use App\Http\Resources\Professor\ProfessorCareerResource;
use App\Http\Resources\SubjectNoticeResource;
use App\Models\Calendar;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\Notice;
use App\Models\ProfessorCareer;
use App\Models\ProfessorEducation;
use App\Models\Setting;
use App\Models\SubjectNotice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $professor = Auth::user();
        return new ProfessorResource($professor);
    }

    public function update(Request $request)
    {
        $professor = Auth::user();
        $request->validate([
            'name_hangul' => 'required|string',
            'name_chinese' => 'required|string',
            'name_english' => 'required|string',
            'dob' => 'required|date',
            'photo' => 'nullable|file',
            'email' => 'required|email|unique:professors,email,' . $professor->id,
            'password' => 'nullable|string|min:6',
            'address' => 'required|string',
            'department_id' => 'required|integer',
            'mobile' => 'required|string',
        ]);

        $professor->name_hangul = $request->name_hangul;
        $professor->name_chinese = $request->name_chinese;
        $professor->name_english = $request->name_english;
        $professor->dob = strtotime($request->dob);
        $professor->photo = $request->file('photo') ? $request->file('photo')->store('professors') : $professor->photo;
        $professor->email = $request->email;

        if ($request->password) {
            $professor->password = bcrypt($request->password);
        }

        $professor->address = $request->address;
        $professor->department_id = $request->department_id;
        $professor->mobile = $request->mobile;
        $professor->professor_no = $request->professor_no;
        $professor->save();

        return new ProfessorResource($professor);
    }
    public function saveCareer(Request $request)
    {
        $request->validate([
            'position' => 'required|string',
            'employer' => 'required|string',
            'department' => 'required|string',
            'period' => 'required|numeric',
        ]);
        $career = null;
        if ($request->id)
            $career = ProfessorCareer::where('id', $request->id)->first();
        else
            $career = new ProfessorCareer();

        $career->professor_id = Auth::user()->id;
        $career->position = $request->position;
        $career->employer = $request->employer;
        $career->department = $request->department;
        $career->period = $request->period;
        $career->save();

        return new ProfessorCareerResource($career);
    }

    public function deleteCareer($id)
    {
        ProfessorCareer::where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
    public function deleteEducation($id)
    {
        ProfessorEducation::where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
    public function careers()
    {
        $careers = ProfessorCareer::where('professor_id', Auth::user()->id)->get();
        return ProfessorCareerResource::collection($careers);
    }
    public function educations()
    {
        $educations = ProfessorEducation::where('professor_id', Auth::user()->id)->get();
        return ProfessorEducationResource::collection($educations);
    }
    public function saveEducation(Request  $request)
    {
        $request->validate([
            'school' => 'required|string',
            'scholarship_s' => 'required|date',
            'scholarship_f' => 'required|date|after_or_equal:scholarship_s',
            'degree' => 'required|string',
        ]);
        $education = null;
        if ($request->id)
            $education = ProfessorEducation::where('id', $request->id)->first();
        else
            $education = new ProfessorEducation();

        $education->professor_id = Auth::user()->id;
        $education->school = $request->school;
        $education->scholarship_s = $request->scholarship_s;
        $education->scholarship_f = $request->scholarship_f;
        $education->degree = $request->degree;
        $education->save();

        return new ProfessorEducationResource($education);
    }
    public function lectures()
    {
        $lectures = Lecture::where('professor_id', Auth::user()->id)->get();

        return LectureResource::collection($lectures);
    }

    public function departments()
    {
        return DepartmentResource::collection(executeQuery(Department::query()));
    }

    public function calendars()
    {
        return CalendarResource::collection(executeQuery(Calendar::query()->where('type', 'Professor')));
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
                ->whereIn('category', ['Professor', 'All'])
        ));
    }

    public function administrationNoticeShow(Notice $notice)
    {
        return new NoticeResource($notice);
    }

    public function subjectNotices()
    {
        $activeSubjects = Auth::guard('professor')->user()->subjects()->get();
        $setting = Setting::latest()->first();

        return SubjectNoticeResource::collection(executeQuery(SubjectNotice::query()->latest()->with('subject')->whereIn('subject_id', $activeSubjects->pluck('id')->toArray())->where('semester_id', $setting->current_semester_id)));
    }

    public function subjectNoticeShow(SubjectNotice $notice)
    {
        return new SubjectNoticeResource($notice);
    }
}
