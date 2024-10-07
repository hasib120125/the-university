<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function index()
    {
        return StaticPageResource::collection(executeQuery(StaticPage::query()));
    }


    public function show(StaticPage $staticPage)
    {
        return new StaticPageResource($staticPage);
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'nullable|string',
            'content_ko' => 'nullable|string',
        ]);

        $staticPage->update($request->except('id'));
    }
}
