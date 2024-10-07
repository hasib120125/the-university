<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function index()
    {
        return PageResource::collection(executeQuery(Page::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'title_en' => 'required|string',
            'description_en' => 'required|string',
            'title_ko' => 'required|string',
            'description_ko' => 'required|string',
            'status' => 'required',
        ]);

        $page = null;

        if($request->sub_id)
            $page = Page::where('menu_id', $request->menu_id)->where('sub_id', $request->sub_id)->first();
        else
            $page = Page::where('menu_id', $request->menu_id)->where('sub_id', null)->first();

        if($request->confirm_updte == 0 && $page)
            return response()->json(['success' => false, 'message' => 'This Page Already Exists. Do you Want to Update Existing Page ?']);

        if($request->confirm_updte == 0)
            $page = new Page();


        $page->menu_id = $request->menu_id;
        $page->sub_id = $request->sub_id;
        $page->title = $request->title_en;
        $page->title_ko = $request->title_ko;
        $page->description = $request->description_en;
        $page->description_ko = $request->description_ko;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->status = $request->status;
        $page->save();

        return new PageResource($page);
    }

    public function show(Page $page)
    {
        return new PageResource($page);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'menu_id' => 'required',
            'title_en' => 'required|string',
            'description_en' => 'required|string',
            'title_ko' => 'required|string',
            'description_ko' => 'required|string',
            'status' => 'required',
        ]);

        $page->menu_id = $request->menu_id;
        $page->sub_id = $request->sub_id;
        $page->title = $request->title_en;
        $page->title_ko = $request->title_ko;
        $page->description = $request->description_en;
        $page->description_ko = $request->description_ko;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->status = $request->status;
        $page->save();

        return new PageResource($page);
    }


    public function destroy(Page $page)
    {
        if(!$page->can_delete){
            return response()->json(['success' => false, 'message' => 'Can not delete.']);
        }

        $page->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
