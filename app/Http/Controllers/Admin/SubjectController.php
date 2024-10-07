<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\StudentGradeResource;
use App\Http\Resources\SubjectResource;
use App\Jobs\CopyAudio;
use App\Jobs\AssignVideo;
use App\Jobs\CopyVideo;
use App\Jobs\VideoConvert;
use App\Models\BulkAudio;
use App\Models\BulkSubtitle;
use App\Models\BulkVideo;
use App\Models\Lecture;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\SubjcetCreditTransaction;
use App\Models\Subject;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectMaterial;
use App\Models\SubjectNotice;
use App\Models\SubjectPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;
use wapmorgan\Mp3Info\Mp3Info;

class SubjectController extends Controller
{
    public function index()
    {
        return SubjectResource::collection(executeQuery(Subject::query()->with('professor')));
    }

    public function store(Request $request)
    {
        $request->merge(['departments' => json_decode($request->departments, true)]);

        $request->validate([
            'name' => 'required|string',
            'max_student' => 'nullable|integer',
            'code' => 'required|unique:subjects,code,NULL,id,deleted_at,NULL',
            'credit' => 'required|numeric',
            'professor_id' => 'required|integer',
            'status' => 'required|boolean',
            'departments.*.id' => 'required',
            'departments.*.subject_type' => 'required',
        ], [
            'professor_id.required' => 'Professor field is required.',
            'departments.*.id.required' => 'The Department field is required',
            'departments.*.subject_type.required' => 'The Subjec type field is required',
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->max_student = $request->max_student;
        $subject->code = $request->code;
        $subject->credit  = $request->credit;
        $subject->professor_id = $request->professor_id;
        $subject->status = $request->status;
        $subject->save();

        $attachData = [];

        foreach ($request->departments as $department) {
            $attachData[$department['id']] = ['subject_type' => $department['subject_type']];
        }
        $subject->departments()->sync($attachData);

        return new SubjectResource($subject->load('professor'));
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject->load('professor'));
    }


    public function update(Request $request, Subject $subject)
    {
        $request->merge(['departments' => json_decode($request->departments, true)]);

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:subjects,code,' . $subject->id . ',id,deleted_at,NULL',
            'credit' => 'required|numeric',
            'professor_id' => 'required|integer',
            'status' => 'required|boolean',
            'departments.*.id' => 'required',
            'departments.*.subject_type' => 'required',
            'max_student' => 'nullable|integer',
        ], [
            'professor_id.required' => 'Professor field is required.',
            'departments.*.id.required' => 'The Department field is required',
            'departments.*.subject_type.required' => 'The Subjec type field is required',
        ]);
        $subject->name = $request->name;
        $subject->code = $request->code;
        $subject->credit  = $request->credit;
        $subject->professor_id = $request->professor_id;
        $subject->status = $request->status;
        $subject->max_student = $request->max_student;
        $subject->save();

        $attachData = [];

        foreach ($request->departments as $department) {
            $attachData[$department['id']] = ['subject_type' => $department['subject_type']];
        }
        $subject->departments()->sync($attachData);

        return new SubjectResource($subject->load('professor'));
    }

    public function destroy(Subject $subject)
    {
        StudentGrade::where('subject_id', $subject->id)->delete();
        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function lectures(Subject $subject, $semester_id)
    {
        $query = $subject->lectures();
        return LectureResource::collection(executeQuery($query->where('semester_id', $semester_id)->with('professor', 'subject', 'semester')));
    }

    public function addStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required'
        ], [
            'student_id.required' => 'The Student is required'
        ]);

        $data = [
            'semester_id' => $request->semester_id,
            'subject_id' => $request->subject_id,
            'student_id' => $request->student_id,
        ];

        $subject = Subject::find($request->subject_id);

        if ($subject->max_student > 0 && StudentGrade::where(['subject_id' => $subject->id, 'semester_id' => $request->semester_id])->count() >= $subject->max_student)
            return response()->json(['error' => 'subject_full', 'message' => trans('common/message.subject_full')]);

        $semester = Semester::find($request->semester_id);

        $student = Student::find($request->student_id);

        StudentGrade::create([
            'subject_id' => $subject->id,
            'subject_name' => $subject->name,
            'credit' => $subject->credit,
            'student_id' => $student->id,
            'student_no' => $student->student_no,
            'semester_id' => $semester->id,
            'semester_code' => $semester->semester_code,
            'semester_year' => $semester->year,
            'semester_season' => $semester->season,
        ]);

        SubjectActiveStudent::create($data);

        return response()->json(['success' => true, 'message' => trans('admin/label.student_add_message')]);
    }

    public function allStudents(Subject $subject, $semester_id)
    {
        $subject = $subject->load(['activeStudents' => function ($q) use ($semester_id) {
            $q->where('semester_id', $semester_id);
        }]);

        $studentIds = $subject->activeStudents->pluck('student_id')->toArray();

        return StudentResource::collection(executeQuery(Student::whereNotIn('id', $studentIds)));
    }

    public function students(Subject $subject, $semester_id)
    {
        $subject = $subject->load(['activeStudents' => function ($q) use ($semester_id) {
            $q->where('semester_id', $semester_id);
        }]);

        $studentIds = $subject->activeStudents->pluck('student_id')->toArray();

        return StudentResource::collection(executeQuery(Student::whereIn('id', $studentIds)));
    }

    public function gradeInput(Subject $subject, $semester_id)
    {
        $studentIds = $subject->activeStudents->pluck('student_id')->toArray();

        $query = StudentGrade::whereIn('student_id', $studentIds)->where('semester_id', $semester_id)->where('subject_id', $subject->id);

        return StudentGradeResource::collection($query->with('subjectPlans', 'student', 'semester')->get());
    }

    public function changePassStatus(Request $request)
    {
        if ($request->grade_id) {
            $student_grade = StudentGrade::where('id', $request->grade_id)->first();
            if ($student_grade) {
                $student_grade->update([
                    'pass' => $student_grade->pass ? 0 : 1
                ]);
            }
        }
    }

    public function clone(Request $request, Subject $subject)
    {
        $this->subjectPlanClone($subject, $request);
        $this->lectureClone($subject, $request);
    }

    function subjectPlanClone($subject, $request)
    {
        $subjectPlan = SubjectPlan::where('subject_id', $subject->id)->where('semester_id', $request->from_semester_id)->with('subjectPlanTopics')->first();

        if ($subjectPlan) {
            $newSubjectPlan = SubjectPlan::where('subject_id', $subject->id)->where('semester_id', $request->to_semester_id)->with('subjectPlanTopics')->first() ?: new SubjectPlan();
            $newSubjectPlan->subject_id = $subject->id;
            $newSubjectPlan->subject_outline = $subjectPlan->subject_outline;
            $newSubjectPlan->semester_id = $request->to_semester_id;
            $newSubjectPlan->textbook = $subjectPlan->textbook;
            $newSubjectPlan->reference_book = $subjectPlan->reference_book;
            $newSubjectPlan->evaluation_standard = $subjectPlan->evaluation_standard;
            $newSubjectPlan->attendance = $subjectPlan->attendance;
            $newSubjectPlan->middle = $subjectPlan->middle;
            $newSubjectPlan->ending = $subjectPlan->ending;
            $newSubjectPlan->etc = $subjectPlan->etc;
            $newSubjectPlan->attendance_mark = $subjectPlan->attendance_mark;
            $newSubjectPlan->middle_mark = $subjectPlan->middle_mark;
            $newSubjectPlan->ending_mark = $subjectPlan->ending_mark;
            $newSubjectPlan->etc_mark = $subjectPlan->etc_mark;

            $newSubjectPlan->save();

            $subjectPlanTopicsData = [];
            foreach ($subjectPlan->subjectPlanTopics as $subjectPlanTopic) {
                $subjectPlanTopicsData[] = [
                    'subject_id' => $newSubjectPlan->subject_id,
                    'date' => $subjectPlanTopic->date,
                    'topic' => $subjectPlanTopic->topic,
                    'remark' => $subjectPlanTopic->remark
                ];
            }

            $newSubjectPlan->subjectPlanTopics()->createMany($subjectPlanTopicsData);
        }
    }

    public function lectureClone($subject, $request)
    {
        $lectures = Lecture::where('subject_id', $subject->id)->where('semester_id', $request->from_semester_id)->get();

        foreach ($lectures as $lecture) {
            //$filename = null;

            /*if ($lecture->original_video) {
                $filetype = pathinfo($lecture->original_video)['extension'];
                $filename = 'temp/'.Str::uuid().'.'.$filetype;

                Storage::disk('public')->writeStream($filename, Storage::disk('media_server')->readStream($lecture->original_video));
            }*/

            $newLecture = Lecture::create([
                'name' => $lecture->name . ' - Clone',
                'subject_id' => $lecture->subject_id,
                'professor_id' => $lecture->professor_id,
                'semester_id' => $request->to_semester_id,
                'bulk_video_id' => $lecture->bulk_video_id,
                'bulk_audio_id' => $lecture->bulk_audio_id,
                'bulk_subtitle_id' => $lecture->bulk_subtitle_id,
                'original_video_file' => $lecture->original_video_file,
                'start_period' => $lecture->start_period,
                'end_period' => $lecture->end_period,
                'description' => $lecture->description,
                'status' => $lecture->status
            ]);

            if ($lecture->bulk_audio_id) {
                $bulkAudio = BulkAudio::find($lecture->bulk_audio_id);

                CopyAudio::dispatch($newLecture, $bulkAudio->filename);
            } elseif ($lecture->audio_file) {
                CopyAudio::dispatch($newLecture, $lecture->audio_file);
            }

            if ($lecture->bulk_video_id) {
                // $bulkVideo = BulkVideo::find($lecture->bulk_video_id);
                // AssignVideo::dispatch($bulkVideo, $newLecture);
                $bulkVideo = BulkVideo::find($request->bulk_video_id);
                AssignVideo::dispatch($bulkVideo, $lecture);
            } elseif ($lecture->original_video_file) {
                CopyVideo::dispatch($lecture, $newLecture);
            }

            if ($lecture->bulk_subtitle_id) {
                $bulkSubtitle = BulkSubtitle::find($lecture->bulk_subtitle_id);
                $lecture->update([
                    'subtitle_file' => $bulkSubtitle->filename,
                    'subtitle_label' => $bulkSubtitle->label,
                ]);
            }
        }
    }

    public function changeStatus(Subject $subject)
    {
        $subject->status = !$subject->status;

        return $subject->save();
    }
}
