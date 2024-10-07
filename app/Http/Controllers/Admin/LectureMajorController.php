<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Curriculum;
use App\Models\Lecture;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LectureMajorController extends Controller
{
    public function index(Lecture $lecture)
    {
        return DepartmentResource::collection(executeQuery($lecture->majors()));
    }
    
    public function store(Request $request, Lecture $lecture)
    {
        $request->validate([
            'curriculum_id' => 'required|integer|exists:curricula,id',
            'grade_year_1' => 'nullable|integer',
            'grade_year_2' => 'nullable|integer',
            'grade_year_3' => 'nullable|integer',
            'grade_year_4' => 'nullable|integer',
            'grade' => 'nullable|numeric',
            'major_category' => 'required|numeric',
        ]);
        
        $lecture->majors()->attach($lecture->id, [
            'curriculum_id'=> $request->curriculum_id,
            'grade_year_1'=> $request->grade_year_1,
            'grade_year_2'=> $request->grade_year_2,
            'grade_year_3'=> $request->grade_year_3,
            'grade_year_4'=> $request->grade_year_4,
            'grade'=> $request->grade ?? 0,
            'major_category'=> $request->major_category,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return DepartmentResource::collection(executeQuery($lecture->majors()));
    }

    public function show(Lecture $lecture, $major)
    {
        return new DepartmentResource($lecture->majors()->where('lecture_major.id', $major)->first());
    }

    public function update(Request $request,Lecture $lecture, $major)
    {
        $request->validate([
            'curriculum_id' => 'required|integer|exists:curricula,id',
            'grade_year_1' => 'nullable|integer',
            'grade_year_2' => 'nullable|integer',
            'grade_year_3' => 'nullable|integer',
            'grade_year_4' => 'nullable|integer',
            'grade' => 'nullable|numeric',
            'major_category' => 'required|numeric',
        ]);

        $lecture->majors()->where('lecture_major.id', $major)
                        ->update([
                            'curriculum_id'=> $request->curriculum_id,
                            'grade_year_1'=> $request->grade_year_1,
                            'grade_year_2'=> $request->grade_year_2,
                            'grade_year_3'=> $request->grade_year_3,
                            'grade_year_4'=> $request->grade_year_4,
                            'grade'=> $request->grade,
                            'major_category'=> $request->major_category,
                        ]);

        return DepartmentResource::collection(executeQuery($lecture->majors()));
    }

    public function destroy(Lecture $lecture, $major)
    {
        $lecture->majors()->where('lecture_major.id', $major)->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
