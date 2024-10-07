<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Import\Models\Score;
use App\Jobs\Import\StudentAdmissionDateJob;
use App\Jobs\Import\StudentGradeJob;
use App\Jobs\Temp\UpdateAttendanceJob;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\SubjectPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Matrix\trace;

class CommonController extends Controller
{
    public function index()
    {
        $this->updateStudentAdmissionDate();
        return 'done';
    }

    public function updateStudentAdmissionDate()
    {
        $students = DB::connection('old')->table("waics_lms_dbo_mb_student_data")->get();

        $take = 30;
        $skip = 0;
        for ($i = 0; $i <= $students->count(); $i += 30) {
            $skip = $i;
            $dStudents = $students->skip($skip)->take($take);
            if ($dStudents->count()) {
                StudentAdmissionDateJob::dispatch($dStudents);
            }
        }
    }

    public function studentGradeSubjectName()
    {
        $student_grades = StudentGrade::with('semester', 'subject', 'student')->get();
        foreach ($student_grades as $student_grade) {
            if ($student_grade->semester) {
                $student_grade->semester_code = $student_grade->semester->semester_code;
                $student_grade->semester_year = $student_grade->semester->year;
                $student_grade->semester_season = $student_grade->semester->season;
            }
            if ($student_grade->subject) {
                $student_grade->subject_name = $student_grade->subject->name;
                $student_grade->credit = $student_grade->subject->credit;
                $student_grade->student_no = $student_grade->student->student_no;
                $student_grade->save();
            }
        }
    }

    public function score()
    {
        $scores = Score::with('lecture')->get();

        $take = 30;
        $skip = 0;
        for ($i = 0; $i <= $scores->count(); $i += 30) {
            $skip = $i;
            $dScores = $scores->skip($skip)->take($take);
            if ($dScores->count()) {
                StudentGradeJob::dispatch($dScores);
            }
        }

        return 'done';
    }

    public function fixAttendance()
    {
        $studentGrades = StudentGrade::where('calculated', false)->get();

        $take = 30;
        $skip = 0;
        for ($i = 0; $i <= $studentGrades->count(); $i += 30) {
            $skip = $i;
            $dStudentGrades = $studentGrades->skip($skip)->take($take);
            if ($dStudentGrades->count()) {
                UpdateAttendanceJob::dispatch($dStudentGrades);
            }
        }

        return 'done';
    }

    public function studentAttendanceCal()
    {
        $studentGrades = StudentGrade::whereNotNull('grade')->update([
            'calculated'=> true
        ]);

    }
}
