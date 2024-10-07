<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GradeSystemResource;

class GradeSystemController extends Controller
{
    public function index()
    {
        return GradeSystemResource::collection(executeQuery(Grade::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required|gt:from',
            'grade' => 'required',
            'point' => 'required',
        ]);

        $grade = new Grade();
        $grade->from = $request->from;
        $grade->to = $request->to;
        $grade->grade = $request->grade;
        $grade->point = $request->point;
        $grade->save();

        return new GradeSystemResource($grade);
    }

    public function show($id)
    {
        $grade = Grade::find($id);
        return new GradeSystemResource($grade);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
            'grade' => 'required',
            'point' => 'required',
        ]);

        $grade = Grade::find($id);

        $grade->from = $request->from;
        $grade->to = $request->to;
        $grade->grade = $request->grade;
        $grade->point = $request->point;

        $grade->save();

        return new GradeSystemResource($grade);
    }

    public function destroy($id)
    {
        $grade = Grade::find($id);

        $grade->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
