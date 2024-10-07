<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SampleLectureResource;
use App\Models\SampleLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Image;

class SampleLectureController extends Controller
{
    public function index()
    {
        return SampleLectureResource::collection(executeQuery(SampleLecture::query()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mkv,avi,mpeg,mpg,3gp,mp4',
        ]);

        $sampleLecture = new SampleLecture();
        $sampleLecture->video = $request->file('video')->store('sample_lecture');

        $durationInSeconds = FFMpeg::fromDisk('public')
            ->open($sampleLecture->video)->getDurationInSeconds();

        $thumbsFilename = Str::uuid().'.png';

        FFMpeg::fromDisk('public')
            ->open($sampleLecture->video )
            ->getFrameFromSeconds(random_int(0, $durationInSeconds))
            ->export()
            ->toDisk('public')
            ->save('sample_lecture/thumbs/'.$thumbsFilename);

        Image::make(public_path('storage/sample_lecture/thumbs/'.$thumbsFilename))->resize(190, 108)->save();

        $sampleLecture->thumbs = 'sample_lecture/thumbs/'.$thumbsFilename;
        $sampleLecture->save();

        return new SampleLectureResource($sampleLecture);
    }


    public function destroy(SampleLecture $sampleLecture)
    {
        $sampleLecture->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
