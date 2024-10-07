<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        return SemesterResource::collection(executeQuery(Semester::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'required',
            'season' => 'required|integer|between:1,4',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after_or_equal:start_period',
            'last_subject_cancel_date' => 'required|date',
            'grade_period' => 'required|date',
        ]);

        $data['semester_code'] = $data['year'] . $data['season'];

        $semester = Semester::create($data);

        return new SemesterResource($semester);
    }

    public function show(Semester $semester)
    {
        return new SemesterResource($semester);
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'year' => 'required|date_format:Y',
            'season' => 'required|integer|between:1,4',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after_or_equal:start_period',
            'last_subject_cancel_date' => 'required|date',
            'grade_period' => 'required|date',
        ]);

        $semester->year = $request->year;
        $semester->season = $request->season;
        $semester->start_period = $request->start_period;
        $semester->end_period = $request->end_period;
        $semester->last_subject_cancel_date = $request->last_subject_cancel_date;
        $semester->grade_period = $request->grade_period;
        $semester->semester_code = $request->year . $request->season;
        $semester->save();

        return new SemesterResource($semester);
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
