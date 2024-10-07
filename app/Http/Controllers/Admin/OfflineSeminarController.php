<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OfflineSeminar;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfflineSeminarResource;
use Illuminate\Support\Facades\Storage;
use Str;
use Image;

class OfflineSeminarController extends Controller
{
    public function index()
    {
        return OfflineSeminarResource::collection(executeQuery(OfflineSeminar::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
            'preview_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($request->hasFile('preview_image')) {
            $image = $request->file('preview_image');
            $thumbsFilename = Str::uuid().'.'.$image->extension();
            $imageFile = Image::make($image->getRealPath())->resize(310, 210, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/offline_seminar/thumbs/'.$thumbsFilename, $imageFile);
            $data['preview_image']= 'offline_seminar/thumbs/'.$thumbsFilename;
        }

        $offlineSeminars = OfflineSeminar::create($data);

        return new OfflineSeminarResource($offlineSeminars);
    }

    public function show($id)
    {
        $offlineSeminars = OfflineSeminar::find($id);
        return new OfflineSeminarResource($offlineSeminars);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $offlineSeminar = OfflineSeminar::find($id);

        if($request->hasFile('preview_image')) {
            $image = $request->file('preview_image');
            $thumbsFilename = Str::uuid().'.'.$image->extension();
            $imageFile = Image::make($image->getRealPath())->resize(310, 210, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/offline_seminar/thumbs/'.$thumbsFilename, $imageFile);
            $data['preview_image']= 'offline_seminar/thumbs/'.$thumbsFilename;
            $offlineSeminar->preview_image = $data['preview_image'];
            if(Storage::exists($offlineSeminar->preview_image))
                Storage::delete($offlineSeminar->preview_image);
        }

        $offlineSeminar->title_en = $request->title_en;
        $offlineSeminar->title_ko = $request->title_ko;
        $offlineSeminar->content_en = $request->content_en;
        $offlineSeminar->content_ko = $request->content_ko;

        $offlineSeminar->save();

        return new OfflineSeminarResource($offlineSeminar);
    }

    public function destroy($id)
    {
        $offlineSeminar = OfflineSeminar::find($id);

        $offlineSeminar->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
