<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentGradeResource;
use App\Models\Grade;
use App\Models\Lecture;
use App\Models\StudentGrade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StudentGradeController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentGrade::query();

        if ($request->department_id) {
            $query->whereHas('student', function (Builder $q) use ($request) {
                $q->where('students.department_id', $request->department_id);
            });
        }

        if ($request->q) {
            if ($request->type == 1) {
                $query->whereHas('student', function (Builder $q) use ($request) {
                    $q->where('students.name_english', 'LIKE', '%' . $request->q . '%')->orWhere('students.name_hangul', 'LIKE', '%' . $request->q . '%');
                });
            } else {
                $query->whereHas('student', function (Builder $q) use ($request) {
                    $q->where('students.student_no', 'LIKE', $request->q);
                });
            }
        }

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        return StudentGradeResource::collection($query->with('subjectPlans', 'semester', 'student')->get());
    }

    public function store(Request $request, Lecture $lecture)
    {
        $request->validate(
            [
                'studentGrades.*.attendance' => 'nullable|numeric|min:0',
                'studentGrades.*.middle' => 'nullable|numeric|min:0',
                'studentGrades.*.ending' => 'nullable|numeric|min:0',
                'studentGrades.*.etc' => 'nullable|numeric|min:0',
                'studentGrades.*.attendance_rate' => 'nullable|numeric|min:0',
            ],
            [
                'studentGrades.*.attendance.numeric' => 'Need Numeric value',
                'studentGrades.*.middle.numeric' => 'Need Numeric value',
                'studentGrades.*.ending.numeric' => 'Need Numeric value',
                'studentGrades.*.etc.numeric' => 'Need Numeric value',
                'studentGrades.*.attendance_rate.numeric' => 'Need Numeric value',
                'studentGrades.*.attendance.min' => 'Minimum value 0',
                'studentGrades.*.middle.min' => 'Minimum value 0',
                'studentGrades.*.ending.min' => 'Minimum value 0',
                'studentGrades.*.etc.min' => 'Minimum value 0',
                'studentGrades.*.attendance_rate.min' => 'Minimum value 0',
            ]
        );

        foreach ($request->studentGrades as $grade) {
            $subjectPlan = $grade['subject_plan'];
            $studentGrade = StudentGrade::find($grade['id'])->load('subject');

            if ($subjectPlan && $studentGrade) {
                $attendance = $grade['attendance'] ?? 0;

                $attendance_rate = $grade['attendance_rate'] ?? $studentGrade->attendance_rate;
                $middle = $grade['middle'] ?? $studentGrade->middle;
                $ending = $grade['ending'] ?? $studentGrade->ending;
                $etc = $grade['etc'] ?? $studentGrade->etc;

                $middleMark = $subjectPlan['middle_mark'] > 0 ? ($middle * $subjectPlan['middle']) / $subjectPlan['middle_mark'] : 0;
                $endingMark = $subjectPlan['ending_mark'] > 0 ? ($ending * $subjectPlan['ending']) / $subjectPlan['ending_mark'] : 0;
                $etcMark = $subjectPlan['etc_mark'] > 0 ? ($etc * $subjectPlan['etc']) / $subjectPlan['etc_mark'] : 0;

                $totalMark = $attendance + $middleMark + $endingMark + $etcMark;

                $calculatedGrade = $this->calculateGrade(floor($totalMark));

                $studentGrade->attendance = $attendance;
                $studentGrade->middle = $middle;
                $studentGrade->ending = $ending;
                $studentGrade->etc = $etc;
                $studentGrade->score = $totalMark;
                $studentGrade->attendance_rate = $attendance_rate;
                $studentGrade->calculated = true;
                $studentGrade->grade = $calculatedGrade ? $calculatedGrade->grade : 'Fail';
                $studentGrade->grades = $calculatedGrade ? $calculatedGrade->point : 0;
                $studentGrade->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Grade stored successfully.']);
    }

    public function calculateGrade($totalMark = 0)
    {
        $grade = Grade::where('from', '<=', $totalMark)->where('to', '>=', $totalMark)->first();

        return $grade;
    }

    public function getAttendanceData(Request $request)
    {
        $studentGrades = $request->studentGrades;

        foreach ($studentGrades as $key => $grade) {
            $subjectPlan = $grade['subject_plan'];
            $studentGrade = StudentGrade::find($grade['id'])->load('subject');

            if ($subjectPlan && $studentGrade) {
                $studentGrades[$key]['attendance'] = $this->attendanceMark($studentGrade, $subjectPlan);
            }
        }

        return $studentGrades;
    }

    public function attendanceMark($studentGrade, $subjectPlan)
    {
        $subject = $studentGrade->subject;
        $subjectPlan = (object) $subjectPlan;

        $lectures = Lecture::where('subject_id', $studentGrade->subject_id)
            ->where('semester_id', $studentGrade->semester_id)
            ->with([
                'lectureProgress' => function ($query) use ($studentGrade) {
                    $query->where('lecture_progress.student_id', $studentGrade->student_id);
                }
            ])
            ->get();

        $attendanceData = $this->calculateAttendance($lectures);

        $lateDeduct = 0.5 / $subject->credit;
        $absentDeduct = 1 / $subject->credit;

        if ($lectures->count() > 28) {
            if ($attendanceData['absent'] >= 12) {
                $attendanceMark = 0;
            } else {
                $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, $lateDeduct, $absentDeduct);
            }
        } elseif ($lectures->count() > 14) {
            if ($attendanceData['absent'] >= 8) {
                $attendanceMark = 0;
            } else {
                $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, $lateDeduct, $absentDeduct);
            }
        } else {
            if ($attendanceData['absent'] >= 4) {
                $attendanceMark = 0;
            } else {
                $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, $lateDeduct, $absentDeduct);
            }
        }

        return $attendanceMark;
    }

    public function calculateLateAbsentMark($data, $lateDeduct, $absentDeduct)
    {
        $lateMark = $data['late'] * $lateDeduct;
        $absentMark = $data['absent'] * $absentDeduct;

        return  $lateMark + $absentMark;
    }

    public function calculateAttendance($lectures  = null)
    {
        $absent = 0;
        $late = 0;
        $present = 0;
        if ($lectures) {
            foreach ($lectures as $lecture) {
                if ($lecture->lectureProgress->count() > 0 && $lecture->lectureProgress[0]) {
                    if ($lecture->lectureProgress[0]['completed'] &&  $lecture->lectureProgress[0]['late']) {
                        $late++;
                    } else if ($lecture->lectureProgress[0]['completed']) {
                        $present++;
                    } else {
                        $absent++;
                    }
                } else {
                    $absent++;
                }
            }
        }

        return ['absent' => $absent, 'present' => $present, 'late' => $late];
    }
}
