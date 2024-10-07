<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentOfPastoralMusicResource;
use App\Models\DepartmentOfPastoralMusic;
use Illuminate\Http\Request;

class DepartmentOfPastoralMusicController extends Controller
{
    public function index()
    {
        return DepartmentOfPastoralMusicResource::collection(executeQuery(DepartmentOfPastoralMusic::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $departmentOfPastoralMusic = DepartmentOfPastoralMusic::create($data);

        return new DepartmentOfPastoralMusicResource($departmentOfPastoralMusic);
    }

    public function show(DepartmentOfPastoralMusic $departmentOfPastoralMusic)
    {
        return new DepartmentOfPastoralMusicResource($departmentOfPastoralMusic);
    }

    public function update(Request $request, DepartmentOfPastoralMusic $departmentOfPastoralMusic)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $departmentOfPastoralMusic->title_en = $request->title_en;
        $departmentOfPastoralMusic->title_ko = $request->title_ko;
        $departmentOfPastoralMusic->content_en = $request->content_en;
        $departmentOfPastoralMusic->content_ko = $request->content_ko;
        $departmentOfPastoralMusic->save();

        return new DepartmentOfPastoralMusicResource($departmentOfPastoralMusic);
    }

    public function destroy(DepartmentOfPastoralMusic $departmentOfPastoralMusic)
    {
        $departmentOfPastoralMusic->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
