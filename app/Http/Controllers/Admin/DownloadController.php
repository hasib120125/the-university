<?php

namespace App\Http\Controllers\Admin;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DownloadResource;

class DownloadController extends Controller
{
    public function index()
    {
        return DownloadResource::collection(executeQuery(Download::query()));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'nullable|string',
            'content_ko' => 'nullable|string',
            'file' => 'required',
        ]);

        $download = Download::create([
            'title_en' => $request->title_en,
            'title_ko' => $request->title_ko,
            'content_en' => $request->content_en,
            'content_ko' => $request->content_ko,
            'file_path' => $request->file('file') ? $request->file('file')->store('downloads') : null,
        ]);

        return new DownloadResource($download);
    }

    public function show($id)
    {
        $download = Download::find($id);
        return new DownloadResource($download);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_en' => 'required|string',
            'title_ko' => 'required|string',
            'content_en' => 'nullable|string',
            'content_ko' => 'nullable|string',
        ]);

        $download = Download::find($id);

        $download->save();

        $download->title_en = $request->title_en;
        $download->title_ko = $request->title_ko;
        $download->content_en = $request->content_en;
        $download->content_ko = $request->content_ko;
        $download->file_path = $request->file('file') ? $request->file('file')->store('downloads') : $download->file_path;
        $download->save();

        return new DownloadResource($download);
    }

    public function destroy($id)
    {
        $download = Download::find($id);

        $download->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
