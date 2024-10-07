<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentTuitionFeeResource;
use App\Models\StudentTuitionFee;
use Illuminate\Http\Request;

class StudentTuitionFeeController extends Controller
{
    public function index()
    {
        return StudentTuitionFeeResource::collection(executeQuery(StudentTuitionFee::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'tuition_fee' => 'numeric',
            'enterance_fee' => 'numeric',
            'seminar_fee' => 'numeric',
            'student_union_fee' => 'numeric',
            'orientation_fee' => 'numeric',
            'deduction' => 'numeric',
            'scholarship' => 'numeric',
        ]);
        $tuitionFee = new StudentTuitionFee();
        $tuitionFee->student_id = $request->student_id;
        $tuitionFee->tuition_fee = $request->tuition_fee;
        $tuitionFee->enterance_fee = $request->enterance_fee;
        $tuitionFee->seminar_fee = $request->seminar_fee;
        $tuitionFee->student_union_fee = $request->student_union_fee;
        $tuitionFee->orientation_fee = $request->orientation_fee;
        $tuitionFee->deduction = $request->deduction;
        $tuitionFee->scholarship = $request->scholarship;
        $tuitionFee->save();

        return new StudentTuitionFeeResource($tuitionFee);
    }

    public function show(StudentTuitionFee $studentTuitionFee)
    {
        return new StudentTuitionFeeResource($studentTuitionFee);
    }

    public function update(Request $request, StudentTuitionFee $studentTuitionFee)
    {
        $request->validate([
            'student_id' => 'required',
            'tuition_fee' => 'numeric',
            'enterance_fee' => 'numeric',
            'seminar_fee' => 'numeric',
            'student_union_fee' => 'numeric',
            'orientation_fee' => 'numeric',
            'deduction' => 'numeric',
            'scholarship' => 'numeric',
        ]);
        $studentTuitionFee->student_id = $request->student_id;
        $studentTuitionFee->tuition_fee = $request->tuition_fee;
        $studentTuitionFee->enterance_fee = $request->enterance_fee;
        $studentTuitionFee->seminar_fee = $request->seminar_fee;
        $studentTuitionFee->student_union_fee = $request->student_union_fee;
        $studentTuitionFee->orientation_fee = $request->orientation_fee;
        $studentTuitionFee->deduction = $request->deduction;
        $studentTuitionFee->scholarship = $request->scholarship;
        $studentTuitionFee->save();

        return new StudentTuitionFeeResource($studentTuitionFee);
    }
    public function destroy(StudentTuitionFee $studentTuitionFee)
    {
        $studentTuitionFee->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
