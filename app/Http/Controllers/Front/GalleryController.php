<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('images')->whereHas('images')->latest()->get();

        return GalleryResource::collection($galleries);
    }

    public function show(Gallery $gallery)
    {
        return new GalleryResource($gallery->load('images'));
    }
}
