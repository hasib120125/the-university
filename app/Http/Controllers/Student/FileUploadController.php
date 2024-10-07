<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function tempFileUpload(Request $request)
    {
        return $request->file('file') ? $request->file('file')->store('temp') : null;
    }

    public function attachmentFileUpload(Request $request)
    {
        return $request->file('file') ? $request->file('file')->store('application-attachment') : null;
    }

    public function attachmentDelete(Request $request)
    {
        if (Storage::exists($request->deleteFile)){
            Storage::delete($request->deleteFile);
        }
    }

    public function imageFileUpload(Request $request)
    {
        return $request->file('image') ? Storage::url($request->file('image')->store('images')) : null;
    }

    public function imageFileDelete(Request $request)
    {
        foreach ($request->images as $image) {
            $filename = basename($image);

            if (Storage::exists('images/' . $filename))
                Storage::delete('images/' . $filename);
        }
    }
}
