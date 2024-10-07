<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentOfMissiologyResource;
use App\Models\DepartmentOfMissiology;
use Illuminate\Http\Request;

class DepartmentOfMissiologyController extends Controller
{
    public function index()
    {
        return DepartmentOfMissiologyResource::collection(executeQuery(DepartmentOfMissiology::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $departmentOfMissiology = DepartmentOfMissiology::create($data);

        return new DepartmentOfMissiologyResource($departmentOfMissiology);
    }

    public function show(DepartmentOfMissiology $departmentOfMissiology)
    {
        return new DepartmentOfMissiologyResource($departmentOfMissiology);
    }


    public function update(Request $request, DepartmentOfMissiology $departmentOfMissiology)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $departmentOfMissiology->title_en = $request->title_en;
        $departmentOfMissiology->title_ko = $request->title_ko;
        $departmentOfMissiology->content_en = $request->content_en;
        $departmentOfMissiology->content_ko = $request->content_ko;
        $departmentOfMissiology->save();

        return new DepartmentOfMissiologyResource($departmentOfMissiology);
    }

    public function destroy(DepartmentOfMissiology $departmentOfMissiology)
    {
        $departmentOfMissiology->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
