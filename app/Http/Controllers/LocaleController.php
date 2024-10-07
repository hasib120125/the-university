<?php

namespace App\Http\Controllers;

use App\Jobs\VideoConvert;
use App\Models\BulkVideo;
use App\Models\GalleryImage;
use App\Models\Lecture;
use App\Models\LectureManagement;
use App\Models\SampleLecture;
use App\Models\Student;
use App\Models\StudentAssignmentSubmit;
use App\Models\StudentSubjectAssignmentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Image;

class LocaleController extends Controller
{
    public function localization()
    {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $dir = explode('/', dirname($file));
            $dir = end($dir);
            $name           = basename($file, '.php');
            $strings[$dir][$name] = require $file;
        }

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }

    public function setLocale(Request $request)
    {
        if (!in_array($request->lang, ['en', 'ko'])) {
            abort(400);
        }

        $request->session()->put('locale', $request->lang);
    }

    public function currentLocale(): string
    {
        return App::currentLocale();
    }

    public function ftpConvert()
    {
        $files = Storage::disk('public')->allfiles('ftp');

        foreach ($files as $file) {
            $bulk = new BulkVideo();
            $bulk->filename = $file;
            $bulk->original_filename = $file;
            $bulk->convert_status = 'Pending';
            $bulk->save();

            VideoConvert::dispatch($bulk, $file);
        }
    }

    public function createThumbs()
    {
        $contents = LectureManagement::all();

        foreach ($contents as $content) {
            if ($content->original_video && !$content->thumbs) {

                $durationInSeconds = FFMpeg::fromDisk('media_server')
                    ->open($content->original_video)->getDurationInSeconds();


                $filename = Str::uuid();

                FFMpeg::fromDisk('media_server')
                    ->open($content->original_video)
                    ->getFrameFromSeconds(random_int(0, $durationInSeconds))
                    ->export()
                    ->toDisk('public')
                    ->save('lecture_thumbs/' . $filename . '.png');

                $content->thumbs = 'lecture_thumbs/' . $filename . '.png';
                $content->save();
            }
        }
    }

    public function createGalleryThumbs()
    {
        $images = GalleryImage::all();

        foreach ($images as $image) {
            $thumbsFilename = Str::uuid().'.jpg';
            $imageFile = Image::make(public_path('/storage/'.$image->image))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $imageFile = $imageFile->__toString();
            Storage::disk('public')->put('/gallery_images/thumbs/'.$thumbsFilename, $imageFile);

            $image->thumbs = 'gallery_images/thumbs/'.$thumbsFilename;
            $image->save();
        }
    }

    public function sampleLectureThumbs()
    {
        $lectures = SampleLecture::all();

        foreach ($lectures as $lecture) {
            if ($lecture->thumbs) {
                $thumbsFilename = Str::uuid() . '.jpg';
                $imageFile = Image::make(public_path('/storage/' . $lecture->thumbs))->resize(190, 108)->stream();
                $imageFile = $imageFile->__toString();
                Storage::disk('public')->put('/sample_lecture/thumbs/' . $thumbsFilename, $imageFile);

                $lecture->thumbs = 'sample_lecture/thumbs/' . $thumbsFilename;
                $lecture->save();
            }
        }
    }

    public function removeUnused()
    {
        $lectures = Lecture::all();
        $bulkVideos = BulkVideo::all();

        $allFiles = array_unique(array_merge($lectures->pluck('original_video_file')->toArray(),
            $lectures->pluck('q_480')->toArray(),
            $lectures->pluck('q_720')->toArray(),
            $lectures->pluck('q_1080')->toArray(),
            $lectures->pluck('smil')->toArray(),
            $bulkVideos->pluck('original_video')->toArray(),
            $bulkVideos->pluck('smil')->toArray(),
            $bulkVideos->pluck('q_480')->toArray(),
            $bulkVideos->pluck('q_720')->toArray(),
            $bulkVideos->pluck('q_1080')->toArray()));

        $files = Storage::disk('media_server')->allfiles('/');

        foreach ($files as $file) {
            if (!in_array($file, $allFiles)) {
                dd($file);
                if (Storage::disk('media_server')->exists($file)) {
                    Storage::disk('media_server')->delete($file);
                }
            }
        }


        dd('stop');
        foreach ($bulkVideo as $item) {
            if (Storage::disk('media_server')->exists($item->original_video)) {
                Storage::disk('media_server')->delete($item->original_video);
            }

            if (Storage::disk('media_server')->exists($item->q_480)) {
                Storage::disk('media_server')->delete($item->q_480);
            }

            if (Storage::disk('media_server')->exists($item->q_720)) {
                Storage::disk('media_server')->delete($item->q_720);
            }

            if (Storage::disk('media_server')->exists($item->q_1080)) {
                Storage::disk('media_server')->delete($item->q_1080);
            }
        }
    }

    public function setAssignment()
    {
        $studentAsignments = DB::table('student_subject_assignment')->get();
        foreach ($studentAsignments as $studentAsignment) {
            $student = Student::find($studentAsignment->student_id);
            $studentAssignmentSubmit = $student->submittedAssignments()->where('subject_assignment_id', $studentAsignment->subject_assignment_id)->first();
            
            if(!$studentAssignmentSubmit){
                $studentAssignmentSubmit = StudentAssignmentSubmit::create([
                    'student_id'=> $student->id, 
                    'subject_assignment_id'=> $studentAsignment->subject_assignment_id,
                    'status'=> $studentAsignment->status,
                ]);

                StudentSubjectAssignmentAttachment::create([
                    'student_assignment_submit_id'=> $studentAssignmentSubmit->id,
                    'file'=> $studentAsignment->attachment1 ? $studentAsignment->attachment1 : null, 
                    'file_name'=> basename($studentAsignment->attachment1)
                ]);
    
                if($studentAsignment->attachment2){
                    StudentSubjectAssignmentAttachment::create([
                        'student_assignment_submit_id'=> $studentAssignmentSubmit->id,
                        'file'=> $studentAsignment->attachment2 ? $studentAsignment->attachment2 : null, 
                        'file_name'=> basename($studentAsignment->attachment2)
                    ]);
                }
            }
        }

        return 'done';
    }

    public function fixStudentAttachment()
    {
        $students = Student::all();

        foreach ($students as $student) {
            if($student->confention_faith_file){
                $this->studentAttachment($student, $student->confention_faith_file);
            }
    
            if($student->study_plan){
                $this->studentAttachment($student, $student->study_plan);
            }
    
            if($student->theological_dissertation_file){
                $this->studentAttachment($student, $student->theological_dissertation_file);
            }
        }

        return 'done';
    }

    public function studentAttachment($student, $attachment)
    {
        if (Storage::exists($attachment)) {
            $file = str_replace("students/","", $attachment);
            try {
                Storage::copy($attachment, 'student_attachments/' . $file);
                $filePath = 'student_attachments/' . $file;

                $student->attachments()->create([
                    'orginal_name' => basename($attachment),
                    'attachment' => $filePath,
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
            
        }
    }
}
