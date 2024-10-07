<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryofMinistryResource;
use App\Models\MinistryofMinistry;
use Illuminate\Http\Request;

class MinistryofMinistryController extends Controller
{
    public function index()
    {
        return MinistryofMinistryResource::collection(executeQuery(MinistryofMinistry::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $ministryOfMinistry = MinistryofMinistry::create($data);

        return new MinistryofMinistryResource($ministryOfMinistry);
    }

    public function show(MinistryofMinistry $ministryOfMinistry)
    {
        return new MinistryofMinistryResource($ministryOfMinistry);
    }


    public function update(Request $request, MinistryofMinistry $ministryOfMinistry)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $ministryOfMinistry->title_en = $request->title_en;
        $ministryOfMinistry->title_ko = $request->title_ko;
        $ministryOfMinistry->content_en = $request->content_en;
        $ministryOfMinistry->content_ko = $request->content_ko;
        $ministryOfMinistry->save();

        return new MinistryofMinistryResource($ministryOfMinistry);
    }

    public function destroy(MinistryofMinistry $ministryOfMinistry)
    {
        $ministryOfMinistry->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
