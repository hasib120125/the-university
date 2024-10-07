<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionCounsellingResource;
use App\Models\AdmissionCounselling;
use Illuminate\Http\Request;

class AdmissionCounsellingController extends Controller
{
    public function index()
    {
        return AdmissionCounsellingResource::collection(executeQuery(AdmissionCounselling::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_en' => 'required|string',
            'question_ko' => 'required|string',
            'answer_en' => 'required|string',
            'answer_ko' => 'required|string',
        ]);

        $admissionCounselling = AdmissionCounselling::create($data);

        return new AdmissionCounsellingResource($admissionCounselling);
    }

    public function show(AdmissionCounselling $admissionCounselling)
    {
        return new AdmissionCounsellingResource($admissionCounselling);
    }


    public function update(Request $request, AdmissionCounselling $admissionCounselling)
    {
        $request->validate([
            'question_en' => 'required|string',
            'question_ko' => 'required|string',
            'answer_en' => 'required|string',
            'answer_ko' => 'required|string',
        ]);

        $admissionCounselling->question_en = $request->question_en;
        $admissionCounselling->question_ko = $request->question_ko;
        $admissionCounselling->answer_en = $request->answer_en;
        $admissionCounselling->answer_ko = $request->answer_ko;
        $admissionCounselling->save();

        return new AdmissionCounsellingResource($admissionCounselling);
    }

    public function destroy(AdmissionCounselling $admissionCounselling)
    {
        $admissionCounselling->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
