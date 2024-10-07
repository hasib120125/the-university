<?php

namespace App\Http\Controllers\Professor;

use App\Models\BulkVideo;
use App\Jobs\VideoConvert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FileUploadController extends Controller
{
    public function tempFileUpload(Request $request)
    {
        return $request->file('file') ? $request->file('file')->store('temp') : null;
    }

    public function tempVideoFileUpload(Request $request)
    {
        return $request->file('file') ?  $request->file('file')->store(
            'temp', 'media_server'
        ) : null;
    }

    public function imageFileUpload(Request $request)
    {
        if($request->froala){
            $file = $request->file('image') ? Storage::url($request->file('image')->store('images')) : null;
            $response = new stdClass;
            $response->link = $file;
            if($file)
                return  stripslashes(json_encode($response));
        }
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
