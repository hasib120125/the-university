<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialResource;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $socials = Social::all();

        return SocialResource::collection($socials);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'class' => 'required|string',
            'status' => 'required',
        ]);

        $social = new Social();
        $social->name = $request->name;
        $social->url = $request->url;
        $social->class = $request->class;
        $social->status = $request->status;
        $social->save();

        return new SocialResource($social);
    }

    public function show(Social $social)
    {
        return new SocialResource($social);
    }


    public function update(Request $request, Social $social)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'class' => 'required|string',
            'status' => 'required',
        ]);

        $social->name = $request->name;
        $social->url = $request->url;
        $social->class = $request->class;
        $social->status = $request->status;
        $social->save();

        return new SocialResource($social);
    }

    public function destroy(Social $social)
    {
        $social->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
