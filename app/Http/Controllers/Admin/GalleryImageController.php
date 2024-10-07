<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryImageResource;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class GalleryImageController extends Controller
{
    public function index(Gallery $gallery)
    {
        $gallery = GalleryImage::where('gallery_id', $gallery->id)->orderBy('sort','asc')->get();
        return GalleryImageResource::collection($gallery);
    }

    public function store(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image'=>'required|image'
        ]);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $thumbsFilename = Str::uuid().'.'.$image->extension();
            $imageFile = Image::make($image->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/gallery_images/thumbs/'.$thumbsFilename, $imageFile);


            $galleryImage = new GalleryImage();
            $galleryImage->image = $request->file('image')->store('gallery_images');
            $galleryImage->thumbs = 'gallery_images/thumbs/'.$thumbsFilename;
            $galleryImage->gallery_id = $gallery->id;
            $galleryImage->save();
            return new GalleryImageResource($galleryImage);
        }

    }


    public function destroy(Gallery $gallery, GalleryImage $image)
    {
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
