<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ArticlePublication;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlePublicationsResource;

class ArticalesPublicationsController extends Controller
{
    public function index()
    {
        return ArticlePublicationsResource::collection(executeQuery(ArticlePublication::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $articlePublications = ArticlePublication::create($data);

        return new ArticlePublicationsResource($articlePublications);
    }

    public function show($id)
    {
        $articlePublication = ArticlePublication::find($id);
        return new ArticlePublicationsResource($articlePublication);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required|string',
            'content_ko' => 'required|string',
        ]);

        $articlePublication = ArticlePublication::find($id);
        $articlePublication->title_en = $request->title_en;
        $articlePublication->title_ko = $request->title_ko;
        $articlePublication->content_en = $request->content_en;
        $articlePublication->content_ko = $request->content_ko;
        $articlePublication->save();

        return new ArticlePublicationsResource($articlePublication);
    }

    public function destroy($id)
    {
        $articlePublication = ArticlePublication::find($id);

        $articlePublication->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
