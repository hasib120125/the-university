<?php

namespace App\Http\Controllers\Admin;

use App\Models\Professor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomSubjectResource;
use App\Http\Resources\Professor\ProfessorResource;
use App\Imports\ProfessorImport;
use App\Models\CustomSubject;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProfessorController extends Controller
{
    public function index()
    {
        return ProfessorResource::collection(executeQuery(Professor::query()->with('customSubject')));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_hangul' => 'required|string',
            'name_chinese' => 'required|string',
            'name_english' => 'required|string',
            'dob' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'details_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'nullable|email|unique:professors',
            'address' => 'nullable|string',
            'custom_subject_id' => 'required|integer',
            'mobile' => 'required|string',
            'phone' => 'nullable|string',
            'details' => 'nullable|string',
            'status' => 'nullable',
            'password' => 'nullable|min:6',
        ],[
            'custom_subject_id.required'=> 'The Subject field is required'
        ]);

        $professor = new Professor();
        $professor->professor_no = 'p'.random_int(100000, 999999);
        $professor->name_hangul = $request->name_hangul;
        $professor->name_chinese = $request->name_chinese;
        $professor->name_english = $request->name_english;
        $professor->dob = $request->dob;
        $professor->photo = $request->file('photo') ? $request->file('photo')->store('professors') : null;
        $professor->details_image = $request->file('details_image') ? $request->file('details_image')->store('professors') : null;
        $professor->email = $request->email;
        $professor->address = $request->address;
        $professor->custom_subject_id = $request->custom_subject_id;
        $professor->mobile = $request->mobile;
        $professor->phone = $request->phone;
        $professor->status = $request->status;
        $professor->details = $request->details;
        $professor->password = $request->password ? bcrypt($request->password) : bcrypt(123456) ;
        $professor->save();

        return new ProfessorResource($professor);
    }

    public function show(Professor $professor)
    {
        return new ProfessorResource($professor);
    }

    public function update(Request $request, Professor $professor)
    {
        $request->validate([
            'name_hangul' => 'required|string',
            'name_chinese' => 'required|string',
            'name_english' => 'required|string',
            'dob' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'details_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'nullable|email|unique:professors,email,'.$professor->id,
            'address' => 'nullable|string',
            'custom_subject_id' => 'required|integer',
            'mobile' => 'required|string',
            'phone' => 'nullable|string',
            'details' => 'nullable|string',
            'status' => 'nullable',
            'password' => 'nullable|min:6',
        ],[
            'custom_subject_id.required'=> 'The Subject field is required'
        ]);

        $professor->name_hangul = $request->name_hangul;
        $professor->name_chinese = $request->name_chinese;
        $professor->name_english = $request->name_english;
        $professor->dob = $request->dob;
        $professor->photo =$request->file('photo') ? $request->file('photo')->store('professors') : $professor->photo;
        $professor->details_image =$request->file('details_image') ? $request->file('details_image')->store('professors') : $professor->details_image;
        $professor->email = $request->email;
        $professor->address = $request->address;
        $professor->custom_subject_id = $request->custom_subject_id;
        $professor->mobile = $request->mobile;
        $professor->details = $request->details;
        $professor->phone = $request->phone;
        $professor->status = $request->status;

        if($request->password){
            $professor->password = bcrypt($request->password);
        }

        $professor->save();

        return new ProfessorResource($professor);
    }

    public function destroy(Professor $professor)
    {
        $professor->email = $professor->email . random_int(100000, 999999);
        $professor->save();

        if(Storage::exists($professor->photo))
            Storage::delete($professor->photo);
            
        $professor->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function excelImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls.,xlsx'
        ]);

        $professorImport = new ProfessorImport;
        Excel::import($professorImport, request()->file('file'));

        return response()->json(['data' => true]);
    }

    public function customSubjects(Request $request)
    {
        return CustomSubjectResource::collection(CustomSubject::all());
    }


    public function import(Request $request)
    {
        ini_set('default_socket_timeout', 6000);

        $request->validate([
            'data' => 'required|array|min:1',
            // 'data.*.email' => 'required|email|min:1|max:190',
            'data.*.ID_NO' => 'required|max:190',
        ]);

        $importDatas = $request['data'];
        foreach ($importDatas as $importData) {
            $professor = Professor::where('email', $importData['EMAIL'] ?? '')->orWhere('professor_no', $importData['ID_NO'])->first();
            if(!$professor) $professor = new professor();

            $professor->professor_no = $importData['ID_NO'];
            $professor->name_hangul = $importData['NAME'] ?? '';
            $professor->name_chinese = $importData['NAME'] ?? '';
            $professor->name_english = $importData['NAME'] ?? '';
            $professor->nid_no = $importData['NID'] ?? '';
            $professor->phone = $importData['TELL'] ?? '';
            $professor->mobile = $importData['CELL'] ?? '';
            $professor->email = $importData['EMAIL'] ?? '';
            $professor->address = $importData['ADDRESS'] ?? '';
            $professor->password = bcrypt(123456);

            $department = Department::where('name', $importData['DEPARTMENT'])->first();
            if(!$department){
                $degree = ['Bachelor', 'Master'];
                $key = array_rand($degree);
                $department = Department::create([
                    'name'=>$importData['DEPARTMENT'],
                    'code'=>rand(100,999), 
                    'degree'=> $degree[$key]
                ]);
            }

            $professor->department_id = $department->id;
            $professor->status = 1;
            $professor->save();

        }
        return response()->json(['success' => true, 'message'=> trans('admin/form.professors.import_done')]);
    }
}
