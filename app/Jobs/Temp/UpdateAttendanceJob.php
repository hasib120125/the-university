<?php

namespace App\Jobs\Temp;

use App\Models\Lecture;
use App\Models\StudentGrade;
use App\Models\SubjectPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAttendanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $studentGrades;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($studentGrades)
    {
        $this->studentGrades = $studentGrades;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->studentGrades as $studentGrade) {
            $subjectPlan = SubjectPlan::where(['subject_id' => $studentGrade->subject_id, 'semester_id' => $studentGrade->semester_id])->first();

            if ($subjectPlan && $studentGrade->semester_id) {
                $lectures = Lecture::where('subject_id', $studentGrade->subject_id)
                                ->where('semester_id', $studentGrade->semester_id)
                                ->with(['lectureProgress' => function($query) use($studentGrade) {
                                        $query->where('lecture_progress.student_id', $studentGrade->student_id);
                                    }
                                ])
                                ->get();

                $attendanceData = $this->calculateAttendance($lectures);
//
//                if($lectures->count() > 28){
//                    if($attendanceData['absent'] >= 12){
//                        $attendanceMark = 0;
//                    }else{
//                        $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.33, 0.16);
//                    }
//                }elseif ($lectures->count() > 14) {
//                    if($attendanceData['absent'] >= 8){
//                        $attendanceMark = 0;
//                    }else{
//                        $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.5, 0.25);
//                    }
//                }else{
//                    if($attendanceData['absent'] >= 4){
//                        $attendanceMark = 0;
//                    }else{
//                        $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 1, 0.5);
//                    }
//                }

                StudentGrade::where(['student_id'=> $studentGrade->student_id, 'semester_id'=> $studentGrade->semester_id, 'subject_id'=> $studentGrade->subject_id])
                                    ->update([
                                        'attendance'=> 0,
                                        'attendance_rate'=> (($attendanceData['present'] + ($attendanceData['late'] * .5 )) / $lectures->count()) * 100,
                                    ]);
            }
        }
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
                }
            }
        }

        return ['absent' => $absent, 'present' => $present, 'late' => $late];
    }
}
