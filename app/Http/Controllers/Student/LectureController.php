<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureProgressResource;
use App\Http\Resources\LectureResource;
use App\Models\Lecture;
use App\Models\LectureProgress;
use App\Models\StudentGrade;
use App\Models\SubjectPlan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        return LectureResource::collection(Lecture::where('status', 1)->where('subject_id', $request->subject_id)->get());
    }

    public function show(Lecture $lecture)
    {
        $student = Auth::guard('student')->user();

        $exists = $student->activeSubjects->pluck('id')->toArray();

        if(in_array($lecture->subject_id, $exists))
            return new LectureResource($lecture->load('lectureWeeks'));

        return response(false, 401);
    }

    public function saveProgress(Request $request)
    {
        $lecture = Lecture::find($request->id);
        $student = Auth::guard('student')->user();

        if (!$lecture || !$student)
            return response(false, 404);

        $progress = LectureProgress::where('student_id', $student->id)
            ->where('lecture_id', $lecture->id)->first();

        if (!$progress) {
            $progress = new LectureProgress();
            $progress->student_id = $student->id;
            $progress->lecture_id = $lecture->id;
            $progress->video_total_time = $lecture->duration;
            $progress->audio_total_time = $lecture->audio_duration;
        }

        $duration = $request->type == 'a' ? $lecture->audio_duration : $lecture->duration;

        if ($request->type == 'a' &&
            ((int) $request->position + 30) <= $lecture->audio_duration) {

            $progress->audio_current_time = $request->position;
            $progress->current_content_type = 'a';
            $progress->audio_progress_percentage = (int) ($request->position * 100) / $duration;
        } elseif ($request->type == 'v' &&
            ((int) $request->position + 30) <= $lecture->duration) {

            $progress->video_current_time = $request->position;
            $progress->current_content_type = 'v';
            $progress->video_progress_percentage = (int) ($request->position * 100) / $duration;
        }

        if (((int) $request->position + 30) >= $duration) {
            if (!$progress->completed) {
                $progress->completed = 1;
                $progress->completed_at = Carbon::now();

                if (Carbon::now()->gte($lecture->end_period->addHours(24)))
                    $progress->late = 1;

                $this->calculateSubjectGrade($lecture, $student);
            }
        }

        $progress->save();

//        if($progress->completed){
//            $this->calculateSubjectGrade($lecture, $student);
//        }

        return new LectureProgressResource($progress);
    }

    public function calculateSubjectGrade($lecture, $student)
    {
        $subjectPlan = SubjectPlan::where(['subject_id'=> $lecture->subject_id, 'semester_id'=> $lecture->semester_id])->first();

        if($subjectPlan && $lecture && $student){
            $lectures = Lecture::where('subject_id', $lecture->subject_id)
                                ->where('semester_id', $lecture->semester_id)
                                ->with(['lectureProgress' => function($query) use($student) {
                                        $query->where('lecture_progress.student_id', $student->id);
                                    }
                                ])
                                ->get();

            $attendanceData = $this->calculateAttendance($lectures);

//            $attendanceMark = 0;
//
//            if($lectures->count() > 28){
//                if($attendanceData['absent'] >= 12){
//                    $attendanceMark = 0;
//                }else{
//                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.33, 0.16);
//                }
//            }elseif ($lectures->count() > 14) {
//                if($attendanceData['absent'] >= 8){
//                    $attendanceMark = 0;
//                }else{
//                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 0.5, 0.25);
//                }
//            }else{
//                if($attendanceData['absent'] >= 4){
//                    $attendanceMark = 0;
//                }else{
//                    $attendanceMark = $subjectPlan->attendance_mark - $this->calculateLateAbsentMark($attendanceData, 1, 0.5);
//                }
//            }

            StudentGrade::where(['student_id'=> $student->id, 'semester_id'=> $lecture->semester_id, 'subject_id'=> $lecture->subject_id])
                                ->update([
                                    'attendance_rate'=> (($attendanceData['present'] + ($attendanceData['late'] * .5 )) / $lectures->count()) * 100,
                                ]);
        }
    }

    public function calculateLateAbsentMark($data, $lateDeduct, $absentDeduct)
    {
        $lateMark = $data['late'] * $lateDeduct;
        $absentMark = $data['absent'] * $absentDeduct;

        return $lateMark + $absentMark;
    }

    public function calculateAttendance($lectures  = null)
    {
        $absent = 0;
        $late = 0;
        $present = 0;
        if($lectures){
            foreach ($lectures as $lecture) {
                if($lecture->lectureProgress->count() > 0 && $lecture->lectureProgress[0]){
                    if($lecture->lectureProgress[0]['completed'] &&  $lecture->lectureProgress[0]['late']){
                        $late++;
                    }
                    else if($lecture->lectureProgress[0]['completed']){
                        $present++;
                    }else{
                        $absent++;
                    }
                }
            }
        }

        return ['absent'=> $absent, 'present'=> $present, 'late'=>$late];
    }
}
