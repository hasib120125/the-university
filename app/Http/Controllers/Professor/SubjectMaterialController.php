<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectMaterialResource;
use App\Models\Lecture;
use App\Models\LectureMaterial;
use App\Models\Subject;
use App\Models\SubjectMaterial;
use Illuminate\Http\Request;

class SubjectMaterialController extends Controller
{
    public function index(Lecture $lecture, Request $request)
    {
        $query = SubjectMaterial::query();

        if ($request->semester_id)
            $query->where('semester_id', $request->semester_id);

        return SubjectMaterialResource::collection(executeQuery($query));
    }

    public function store(Request $request, Subject $subject)
    {
        $request->validate([
            'title' => 'required|string',
            'semester_id' => 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $material = $subject->materials()->create([
            'title' => $request->title,
            'semester_id' => $request->semester_id,
            'description' => $request->description,
            'attachment1' => $request->file('attachment1') ? $request->file('attachment1')->store('material_attachments') : null,
            'attachment2' => $request->file('attachment2') ? $request->file('attachment2')->store('material_attachments') : null,
        ]);

        return new SubjectMaterialResource($material);
    }

    public function show(Subject $subject, SubjectMaterial $material)
    {
        return new SubjectMaterialResource($material);
    }

    public function update(Request $request, Subject $subject, SubjectMaterial $material)
    {
        $request->validate([
            'title' => 'required|string',
            'semester_id' => 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $material->title = $request->title;
        $material->semester_id = $request->semester_id;
        $material->description = $request->description;
        $material->attachment1 = $request->file('attachment1') ? $request->file('attachment1')->store('lecture_material_attachments') : $material->attachment1;
        $material->attachment2 = $request->file('attachment2') ? $request->file('attachment2')->store('lecture_material_attachments') : $material->attachment2;
        $material->save();

        return new SubjectMaterialResource($material);
    }

    public function destroy(Lecture $lecture, LectureMaterial $material)
    {
        $material->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
