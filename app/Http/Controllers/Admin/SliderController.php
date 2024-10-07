<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
class SliderController extends Controller
{

    public function index()
    {
        return SliderResource::collection(executeQuery(Slider::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'nullable|string',
            'text' => 'nullable|string',
            'url' => 'nullable|string',
            'image' => 'required|image',
        ]);
        $filename = null;
        if($request->hasFile('image')) {
            $sliderNew = $request->file('image');
            $filename = Str::uuid().'.'.$sliderNew->extension();
            $imageFile = Image::make($sliderNew->getRealPath())->resize(1920, 789)->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/sliders/'.$filename, $imageFile);
            $filename = 'sliders/'.$filename;
        }

        $slider = new Slider();
        $slider->heading = $request->heading;
        $slider->text = $request->text;
        $slider->url = $request->url;
        $slider->image = $filename;
        $slider->save();

        return new SliderResource($slider);
    }

    public function show(Slider $slider)
    {
        return new SliderResource($slider);
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'heading' => 'nullable|string',
            'text' => 'nullable|string',
            'url' => 'nullable|string',
            'image' => 'image|nullable',
        ]);

        $filename = $slider->image;
        if($request->hasFile('image')) {
            $sliderNew = $request->file('image');
            $filename = Str::uuid().'.'.$sliderNew->extension();
            $imageFile = Image::make($sliderNew->getRealPath())->resize(1920, 789)->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/sliders/'.$filename, $imageFile);
            $filename = 'sliders/'.$filename;

            if(Storage::exists($slider->image))
                Storage::delete($slider->image);
        }

        $slider->heading = $request->heading;
        $slider->text = $request->text;
        $slider->url = $request->url;
        $slider->image = $filename;
        $slider->save();

        return new SliderResource($slider);
    }

    public function destroy(Slider $slider)
    {
        if(Storage::exists($slider->image))
            Storage::delete($slider->image);

        $slider->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
