<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SemesterResource;
use App\Http\Resources\SubjectResource;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    protected $professor = null;
    
    public function __construct()
    {
        $this->professor = Auth::guard('professor')->user();
    }
    
    public function index()
    {
        return SubjectResource::collection(executeQuery($this->professor->subjects()->distinct()));
    }

    public function semesters()
    {
        return SemesterResource::collection(executeQuery(Semester::query()));
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }

    public function lectures(Subject $subject, $semester_id)
    {
        $query = $subject->lectures()->where('professor_id', $this->professor->id);
        return LectureResource::collection(executeQuery($query->where('semester_id', $semester_id)->with('professor','subject','semester')));
    }

}
