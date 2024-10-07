<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectActiveStudentResource;
use App\Http\Resources\SubjectPlanResource;
use App\Http\Resources\SubjectResource;
use App\Models\CreditTransaction;
use App\Models\LectureProgress;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\SubjectActiveStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
{
    protected $student = '';

    public function __construct()
    {
        $this->student = Auth::guard('student')->user();
    }

    public function index()
    {
        $setting = Setting::latest()->first();
        return SubjectActiveStudentResource::collection(executeQuery($this->student->activeSubjects()
                                        ->with(['subject.professor','semester'])->where('semester_id', $setting->current_semester_id)->whereHas('subject')));
    }

    public function dashboard()
    {
        $setting = Setting::latest()->first();

        return SubjectActiveStudentResource::collection(executeQuery($this->student->activeSubjects()
            ->with(['subject.professor','semester'])->where('semester_id', $setting->current_semester_id)->whereHas('subject')));
    }


    public function store(Request $request)
    {
        //
    }

    public function show(SubjectActiveStudent $subject)
    {
        $data = $subject->subject->load(['departments', 'lectures' => function($q) use($subject) {
            $q->where('convert_status', 'Completed');
            $q->where('semester_id', $subject->semester_id);
            $q->whereDate('start_period', '<=',  Carbon::now());
            $q->where('status', 1);
            $q->with('progress');
        }]);

        foreach ($data->lectures as $lecture) {
            $progress = $lecture->progress->first();
            if ($progress && $progress->completed != 1 ){
                if (Carbon::now()->gte($lecture->end_period->addHours(24))){
                    $progress->late = 1;
                    $progress->save();
                }
            }
        }

        $setting = Setting::first();

        foreach ($subject->subject->lectures as $lecture)
            $lecture->audio_thumbs = Storage::url($setting->audio_image);

        return new SubjectResource($data);
    }

    public function update(Request $request, Subject $subject)
    {
        //
    }

    public function subjectPlan(SubjectActiveStudent $subject)
    {
        $plan = $subject->subject->subjectPlans()->where('semester_id', $subject->semester_id)
            ->with('subjectPlanTopics', 'subject', 'semester')->first();

        if ($plan)
            return new SubjectPlanResource($plan);

        return null;
    }

    public function destroy(SubjectActiveStudent $subject)
    {
        $mainSubject = Subject::find($subject->subject_id);
        $payment = Payment::create([
            'payment_id' => 'ICS'.random_int(100000, 999999),
            'amount' => 0,
            'note' => '신용 반환',
            'type' => 1,
            'status' => 1,
            'student_id' => $this->student->id,
            'attachment' => null,
        ]);

        $transaction = new CreditTransaction();
        $transaction->payment_id = $payment->id;
        $transaction->student_id = $payment->student_id;
        $transaction->type = $payment->type;
        $transaction->credit = $mainSubject->credit;
        $transaction->per_credit_rate = 0;
        $transaction->save();

       $this->student->increment('available_credit', $transaction->credit);

        $subjectLectures = $subject->subject->load(['lectures' => function($q) use($subject) {
                $q->where('semester_id', $subject->semester_id);
            }]);

        $lectureIds = $subjectLectures->lectures->pluck('id')->toArray();
        LectureProgress::whereIn('lecture_id', $lectureIds)->where('student_id', $this->student->id)->delete();
        StudentGrade::where(['subject_id'=> $subject->subject_id, 'student_id'=> $subject->student_id, 'semester_id'=> $subject->semester_id])->delete();
        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
