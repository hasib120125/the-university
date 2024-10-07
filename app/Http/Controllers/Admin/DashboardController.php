<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SemesterResource;
use App\Http\Resources\SubjectExamResource;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\LectureManagementProgress;
use App\Models\LectureProgress;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectExam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function recentView()
    {
        $labels = [];
        $data= [];

        for($i=6; $i >= 0; $i--) {
            $date = Carbon::now()->subDay($i);

            $labels[] = $date->format('d M');
            $data[] = LectureProgress::whereDate('completed_at', $date)->count();
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function totalStudentsCount()
    {
        return response()->json(['data' => Student::count()]);
    }

    public function activeStudentsCount()
    {
        return response()->json(['data' => Student::where('active', 1)->count()]);
    }

    public function subjectsCount()
    {
        return response()->json(['data' => Subject::count()]);
    }

    public function departmentsCount()
    {
        return response()->json(['data' => Department::count()]);
    }

    public function upcomingLectures()
    {
        return LectureResource::collection(Lecture::with('subject')->latest()->take(10)->get());
    }

    public function upcomingExams()
    {
        return SubjectExamResource::collection(SubjectExam::latest()->take(10)->get());
    }

    public function upcomingSemesters()
    {
        return SemesterResource::collection(Semester::latest()->take(10)->get());
    }

    public function studentBySemester()
    {
        $labels = [];
        $data= [];

        $semesters = Semester::latest()->take(10)->with('students')->get();

        foreach ($semesters as $semester) {
            $labels[] = $semester->year. '-'.  $this->seasonName($semester->season);
            $data[] = $semester->students->count();
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

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

    public function topSubjects()
    {
        $labels = [];
        $data= [];

        $subjects = Subject::withCount('activeStudents')->orderBy('active_students_count', 'desc')->take(10)->get();

        foreach ($subjects as $subject) {
            $labels[] = $subject->name;
            $data[] = $subject->active_students_count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function topDepartments()
    {
        $labels = [];
        $data = [];

        $departments = Department::withCount('students')->orderBy('students_count', 'desc')->take(10)->get();

        foreach ($departments as $department) {
            $labels[] = $department->name;
            $data[] = $department->students_count;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

}
