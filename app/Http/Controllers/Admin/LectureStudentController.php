<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureActiveStudentResource;
use App\Http\Resources\LecturePendingStudentResource;
use App\Http\Resources\Student\StudentResource;
use App\Models\Lecture;
use App\Models\Student;
use Illuminate\Http\Request;

class LectureStudentController extends Controller
{
    public function pendingStudents(Lecture $lecture)
    {
        return StudentResource::collection(executeQuery($lecture->pendingStudents()));
    }

    public function pendingStudentsApprove(Lecture $lecture, Student $student)
    {
        if ($lecture->activeStudents->count() > $lecture->participants) {
            return response()->json(['success' => false, 'message' => 'This course already full, delete some student then approve.']);
        }

        $student->pendingLecture()->detach($lecture->id);
        $student->activeLecture()->attach($lecture->id);

        $student->gradeInput()->create([
            'lecture_id'=> $lecture->id,
            'attendance'=> 0,
            'middle'=> 0,
            'ending'=> 0,
            'etc'=> 0,
            'attendance_rate'=> 0
        ]);

        return response()->json(['success' => true, 'message' => 'Successfully approved.']);
    }

    public function pendingStudentsReject(Lecture $lecture, Student $student)
    {
        $student->pendingLecture()->detach($lecture->id);

        return response()->json(['success' => true, 'message' => 'Successfully rejected.']);
    }

    public function activeStudents(Lecture $lecture)
    {
        return StudentResource::collection(executeQuery($lecture->activeStudents()));
    }

    public function activeStudentsDelete(Lecture $lecture, Student $student)
    {
        $student->gradeInput()->delete();
        $student->activeLecture()->detach($lecture->id);

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
