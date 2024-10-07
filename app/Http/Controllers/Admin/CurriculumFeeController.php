<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurriculumFee;
use Illuminate\Http\Request;
use App\Http\Resources\CurriculumFeeResource;

class CurriculumFeeController extends Controller
{
    public function index()
    {
        return CurriculumFeeResource::collection(executeQuery(CurriculumFee::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required',
            'curriculum_id' => 'required',
            'grade' => 'required|integer|between:1,4',
            'subject_fee' => 'required|numeric',
            'others_fee' => 'required|numeric',
            'orientation_fee' => 'required|numeric',
        ]);

        $curriculumFee = new CurriculumFee();
        $curriculumFee->semester_id = $request->semester_id;
        $curriculumFee->curriculum_id = $request->curriculum_id;
        $curriculumFee->grade = $request->grade;
        $curriculumFee->subject_fee = $request->subject_fee;
        $curriculumFee->others_fee = $request->others_fee;
        $curriculumFee->orientation_fee = $request->orientation_fee;
        $curriculumFee->save();

        return new CurriculumFeeResource($curriculumFee);
    }

    public function show(CurriculumFee $curriculumFee)
    {
        return new CurriculumFeeResource($curriculumFee);
    }

    public function update(Request $request, CurriculumFee $curriculumFee)
    {
        $request->validate([
            'semester_id' => 'required',
            'curriculum_id' => 'required',
            'grade' => 'required|integer|between:1,4',
            'subject_fee' => 'required|numeric',
            'others_fee' => 'required|numeric',
            'orientation_fee' => 'required|numeric',
        ]);

        $curriculumFee->semester_id = $request->semester_id;
        $curriculumFee->curriculum_id = $request->curriculum_id;
        $curriculumFee->grade = $request->grade;
        $curriculumFee->subject_fee = $request->subject_fee;
        $curriculumFee->others_fee = $request->others_fee;
        $curriculumFee->orientation_fee = $request->orientation_fee;
        $curriculumFee->save();

        return new CurriculumFeeResource($curriculumFee);
    }

    public function destroy(CurriculumFee $curriculumFee)
    {
        $curriculumFee->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
