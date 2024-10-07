<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    public function index()
    {
        return NewsResource::collection(executeQuery(News::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required',
            'content_ko' => 'required',
            'summary_en' => 'required',
            'summary_ko' => 'required',
            'banner' => 'required|image',
        ]);
        
        $file = $request->file('banner');
        $filename = Str::uuid().'.'.$file->extension();
        $thumbFile = Image::make($file->getRealPath())->resize(472, 267)->stream()->__toString();
        Storage::disk('public')->put('news/thumb/'.$filename, $thumbFile);
        $thumbImage = 'news/thumb/'.$filename;

        $coverFile = Image::make($file->getRealPath())
                                    ->resize(945, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->stream()->__toString();

        Storage::disk('public')->put('news/cover/'.$filename, $coverFile);
        $coverImage = 'news/cover/'.$filename;

        $news = News::create([
            'title_en' => $request->title_en,
            'title_ko' => $request->title_ko,
            'content_en' => $request->input('content_en'),
            'content_ko' => $request->input('content_ko'),
            'summary_en' => $request->input('summary_en'),
            'summary_ko' => $request->input('summary_ko'),
            'thumbs' => $thumbImage,
            'cover' => $coverImage,
        ]);

        return new NewsResource($news);
    }

    public function show(News $news)
    {
        return new NewsResource($news);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'required',
            'content_ko' => 'required',
            'summary_en' => 'required',
            'summary_ko' => 'required',
            'banner' => 'nullable|image',
        ]);

        $news->title_en = $request->title_en;
        $news->title_ko = $request->title_ko;
        $news->content_en = $request->input('content_en');
        $news->content_ko = $request->input('content_ko');
        $news->summary_en = $request->input('summary_en');
        $news->summary_ko = $request->input('summary_ko');

        if ($request->banner) {
            $file = $request->file('banner');
            $filename = Str::uuid().'.'.$file->extension();
            $thumbFile = Image::make($file->getRealPath())->resize(472, 267)->stream()->__toString();
            Storage::disk('public')->put('news/thumb/'.$filename, $thumbFile);
            $thumbImage = 'news/thumb/'.$filename;

            $coverFile = Image::make($file->getRealPath())
                                        ->resize(945, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        })->stream()->__toString();

            Storage::disk('public')->put('news/cover/'.$filename, $coverFile);
            $coverImage = 'news/cover/'.$filename;

            if (Storage::exists($news->thumbs)) {
                Storage::delete($news->thumbs);
            }

            if (Storage::exists($news->cover)) {
                Storage::delete($news->cover);
            }

            $news->thumbs = $thumbImage;
            $news->cover = $coverImage;
        }

        $news->save();

        return new NewsResource($news);
    }

    public function destroy(News $news)
    {
        if(Storage::exists($news->thumbs))
            Storage::delete($news->thumbs);

        if(Storage::exists($news->cover))
            Storage::delete($news->cover);

        $news->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
