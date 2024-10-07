<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        return FacultyResource::collection(executeQuery(Faculty::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:faculties,code,NULL,id,deleted_at,NULL'
        ]);

        $faculty = new Faculty();
        $faculty->name = $request->name;
        $faculty->code = $request->code;
        $faculty->save();

        return new FacultyResource($faculty);
    }

    public function show(Faculty $faculty)
    {
        return new FacultyResource($faculty);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:faculties,code,'.$faculty->id.',id,deleted_at,NULL'
        ]);

        $faculty->name = $request->name;
        $faculty->code = $request->code;
        $faculty->save();

        return new FacultyResource($faculty);
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
