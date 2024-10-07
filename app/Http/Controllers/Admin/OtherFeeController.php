<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OtherFeeResource;
use App\Models\OtherFee;
use Illuminate\Http\Request;

class OtherFeeController extends Controller
{
    public function index()
    {
        return new OtherFeeResource(OtherFee::first());
    }

    public function update(Request $request, OtherFee $otherFee)
    {
        $request->validate([
            'entrance' => 'nullable|numeric',
            'seminar_fees' => 'nullable|numeric',
            'student_union' => 'nullable|numeric',
            'orientation' => 'nullable|numeric',
        ]);

        $otherFee->entrance = $request->entrance ?? $otherFee->entrance;
        $otherFee->seminar_fees = $request->seminar_fees ?? $otherFee->seminar_fees;
        $otherFee->student_union = $request->student_union ?? $otherFee->student_union;
        $otherFee->orientation = $request->orientation ?? $otherFee->orientation;
        $otherFee->save();

        return new OtherFeeResource($otherFee);
    }
}
