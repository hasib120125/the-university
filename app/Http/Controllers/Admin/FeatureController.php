<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use File;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        return FeatureResource::collection($features);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'name_ko'=>'required|string',
            'text'=>'required|string',
            'text_ko'=>'required|string',
            'image'=>'required|image',
        ]);


        $filename = null;
        if($request->hasFile('image')) {
            $sliderNew = $request->file('image');
            $filename = Str::uuid().'.'.$sliderNew->extension();
            $imageFile = Image::make($sliderNew->getRealPath())->resize(236, 176)->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/feature/'.$filename, $imageFile);
            $filename = 'feature/'.$filename;
        }

        $feature = new Feature();
        $feature->name = $request->name;
        $feature->name_ko = $request->name_ko;
        $feature->text = $request->text;
        $feature->text_ko = $request->text_ko;
        $feature->image = $filename;
        $feature->status = $request->status;
        $feature->save();
    }

    public function show(Feature $feature)
    {
        return new FeatureResource($feature);
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name'=>'required|string',
            'name_ko'=>'required|string',
            'text'=>'required|string',
            'text_ko'=>'required|string',
            'image'=>'image|nullable',
        ]);


        $filename = $feature->image;
        if($request->hasFile('image')) {
            $sliderNew = $request->file('image');
            $filename = Str::uuid().'.'.$sliderNew->extension();
            $imageFile = Image::make($sliderNew->getRealPath())->resize(236, 176)->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/feature/'.$filename, $imageFile);
            $filename = 'feature/'.$filename;

            if(Storage::exists($feature->image))
                Storage::delete($feature->image);
        }

        $feature->name = $request->name;
        $feature->name_ko = $request->name_ko;
        $feature->text = $request->text;
        $feature->text_ko = $request->text_ko;
        $feature->image = $filename;
        $feature->status = $request->status;
        $feature->save();
    }


    public function destroy(Feature $feature)
    {
        if(Storage::exists($feature->image))
            Storage::delete($feature->image);

        $feature->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
