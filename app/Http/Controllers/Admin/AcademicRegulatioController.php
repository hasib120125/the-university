<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicRegulationResource;
use App\Models\AcademicRegulation;
use Illuminate\Http\Request;

class AcademicRegulatioController extends Controller
{
    public function index()
    {
        return AcademicRegulationResource::collection(executeQuery(AcademicRegulation::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $academicRegulation = AcademicRegulation::create($data);

        return new AcademicRegulationResource($academicRegulation);
    }

    public function show(AcademicRegulation $academicRegulation)
    {
        return new AcademicRegulationResource($academicRegulation);
    }


    public function update(Request $request, AcademicRegulation $academicRegulation)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $academicRegulation->title_en = $request->title_en;
        $academicRegulation->title_ko = $request->title_ko;
        $academicRegulation->content_en = $request->content_en;
        $academicRegulation->content_ko = $request->content_ko;
        $academicRegulation->save();

        return new AcademicRegulationResource($academicRegulation);
    }

    public function destroy(AcademicRegulation $academicRegulation)
    {
        $academicRegulation->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
