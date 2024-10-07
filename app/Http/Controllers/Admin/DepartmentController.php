<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    public function index()
    {
        return DepartmentResource::collection(executeQuery(Department::query()));
    }

    public function show(Department $department)
    {
        return new DepartmentResource($department);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:departments,code,NULL,id,deleted_at,NULL',
            'degree' => 'required|in:Bachelor,Master',
            'status' => 'required|boolean',
        ]);

        $department = Department::create($data);

        return new DepartmentResource($department);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:departments,code,' . $department->id . ',id,deleted_at,NULL',
            'degree' => 'required|in:Bachelor,Master',
            'status' => 'required|boolean',
        ]);

        $department->name = $request->name;
        $department->code = $request->code;
        $department->degree = $request->degree;
        $department->status = $request->status;
        $department->save();

        return new DepartmentResource($department);
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
