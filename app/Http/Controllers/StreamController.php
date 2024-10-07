<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class StreamController extends Controller
{
    public function streamFile(Request $request) {
        $fullsize = Storage::size($request->path);
        $size = $fullsize;
        $stream = fopen('storage/'.$request->path, "r");
        $response_code = 200;
        $headers = array("Content-type" => $request->contentType);

        // Check for request for part of the stream
        $range = $request->header('Range');
        if($range != null) {
            $eqPos = strpos($range, "=");
            $toPos = strpos($range, "-");
            $unit = substr($range, 0, $eqPos);
            $start = intval(substr($range, $eqPos+1, $toPos));
            $success = fseek($stream, $start);
            if($success == 0) {
                $size = $fullsize - $start;
                $response_code = 206;
                $headers["Accept-Ranges"] = $unit;
                $headers["Content-Range"] = $unit . " " . $start . "-" . ($fullsize-1) . "/" . $fullsize;
            }
        }

        $headers["Content-Length"] = $size;

        return Response::stream(function () use ($stream) {
            fpassthru($stream);
        }, $response_code, $headers);
    }
}
