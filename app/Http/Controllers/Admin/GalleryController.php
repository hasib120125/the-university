<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return GalleryResource::collection(executeQuery(Gallery::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_kr'=>'required',
            'name_en'=>'required',
        ]);

        $gallery = new Gallery();
        $gallery->name_en = $request->name_en;
        $gallery->name_kr = $request->name_kr;
        $gallery->description_en = $request->description_en;
        $gallery->description_kr = $request->description_kr;
        $gallery->save();

        return new GalleryResource($gallery);
    }

    public function show(Gallery $gallery)
    {
        return new GalleryResource($gallery->load('images'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'name_kr'=>'required',
            'name_en'=>'required',
        ]);

        $gallery->name_en = $request->name_en;
        $gallery->name_kr = $request->name_kr;
        $gallery->description_en = $request->description_en;
        $gallery->description_kr = $request->description_kr;
        $gallery->save();

        return new GalleryResource($gallery);
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
