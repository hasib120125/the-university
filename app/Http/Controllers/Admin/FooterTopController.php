<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FooterTopResource;
use App\Models\FooterTop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterTopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FooterTopResource::collection(executeQuery(FooterTop::query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'link' => 'nullable'
        ]);

        $footerTop = new FooterTop();
        $footerTop->link = $request->link;

        if($request->hasFile('image')) {
            $footerTop->image = $request->file('image')->store('footer_top');
        }

        $footerTop->save();

        return new FooterTopResource($footerTop);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FooterTop  $footerTop
     * @return \Illuminate\Http\Response
     */
    public function show(FooterTop $footerTop)
    {
        return new FooterTopResource($footerTop);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FooterTop  $footerTop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FooterTop $footerTop)
    {
        $request->validate([
            'image' => 'nullable',
            'link' => 'nullable'
        ]);

        $footerTop->link = $request->link;

        if($request->hasFile('image')) {
            if(Storage::exists($footerTop->image))
                Storage::delete($footerTop->image);

            $footerTop->image = $request->file('image')->store('footer_top');
        }

        $footerTop->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FooterTop  $footerTop
     * @return \Illuminate\Http\Response
     */
    public function destroy(FooterTop $footerTop)
    {
        if(Storage::exists($footerTop->image))
            Storage::delete($footerTop->image);

        return $footerTop->delete();
    }
}
