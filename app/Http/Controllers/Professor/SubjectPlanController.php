<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectPlanResource;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\SubjectPlan;
use App\Models\SubjectPlanTopic;
use Illuminate\Http\Request;

class SubjectPlanController extends Controller
{
    public function index(Subject $subject)
    {
        return SubjectPlanResource::collection($subject->subjectPlans());
    }

    public function store(Request $request, Subject $subject)
    {
        $data = $request->validate([
                'course_objective'=>'nullable|string',
                'subject_outline'=>'nullable|string',
                'textbook'=>'nullable|string',
                'reference_book'=>'nullable|string',
                'evaluation_standard'=>'nullable|string',
                'attendance'=>'nullable|numeric',
                'middle'=>'nullable|numeric',
                'ending'=>'nullable|numeric',
                'etc'=>'nullable|numeric',
                'attendance_mark'=>'nullable|numeric',
                'middle_mark'=>'nullable|numeric',
                'ending_mark'=>'nullable|numeric',
                'etc_mark'=>'nullable|numeric',
                'semester_id'=>'required|integer|exists:semesters,id',
                'subject_plan_topics.*.date' => 'nullable|date',
                'subject_plan_topics.*.topic' => 'nullable|string',
                'subject_plan_topics.*.remark' => 'nullable|string',
            ],
            [
                'subject_plan_topics.*.date.date' => 'date field must be in date format',
                'subject_plan_topics.*.topic.string' => 'topic field must be string',
                'subject_plan_topics.*.remark.string' => 'remark field must be string',
            ]
        );

        $data['attendance'] = $request->attendance ?? 25;
        $data['middle'] = $request->middle ?? 30;
        $data['ending'] = $request->ending ?? 30;
        $data['etc'] = $request->etc ?? 15;
        $data['subject_id'] = $subject->id;
        $data['semester_id'] = $request->semester_id;

        $subjectPlan = SubjectPlan::create($data);

        if(count($request->subject_plan_topics)){
            $subjectPlanTopicsData = [];
            foreach ($request->subject_plan_topics as $subject_plan_topic) {
                if($subject_plan_topic['topic']){
                    $subjectPlanTopicsData[] = [
                        'subject_id' => $subjectPlan->subject_id,
                        'date' => $subject_plan_topic['date'],
                        'topic' => $subject_plan_topic['topic'],
                        'remark' => $subject_plan_topic['remark']
                    ];
                }
            }

            $subjectPlan->subjectPlanTopics()->createMany($subjectPlanTopicsData);
        }

        return new SubjectPlanResource($subjectPlan);

    }

    public function show(Subject $subject, SubjectPlan $subjectPlan)
    {
        return new SubjectPlanResource($subjectPlan);
    }

    public function update(Request $request, Subject $subject, SubjectPlan $subjectPlan)
    {
        $request->validate([
                'course_objective'=>'nullable|string',
                'subject_outline'=>'nullable|string',
                'textbook'=>'nullable|string',
                'reference_book'=>'nullable|string',
                'evaluation_standard'=>'nullable|string',
                'attendance'=>'nullable|numeric',
                'middle'=>'nullable|numeric',
                'ending'=>'nullable|numeric',
                'etc'=>'nullable|numeric',
                'attendance_mark'=>'nullable|numeric',
                'middle_mark'=>'nullable|numeric',
                'ending_mark'=>'nullable|numeric',
                'etc_mark'=>'nullable|numeric',
                'semester_id'=>'required|integer|exists:semesters,id',
                'subject_plan_topics.*.date' => 'nullable|date',
                'subject_plan_topics.*.topic' => 'required|string',
                'subject_plan_topics.*.remark' => 'nullable|string',
            ],
            [
                'subject_plan_topics.*.date.date' => 'date field must be in date format',
                'subject_plan_topics.*.topic.required' => 'topic field is required',
                'subject_plan_topics.*.topic.string' => 'topic field must be string',
                'subject_plan_topics.*.remark.string' => 'remark field must be string',
            ]
        );

        $subjectPlan->subject_outline = $request->subject_outline;
        $subjectPlan->textbook = $request->textbook;
        $subjectPlan->reference_book = $request->reference_book;
        $subjectPlan->evaluation_standard = $request->evaluation_standard;
        $subjectPlan->attendance = $request->attendance ?? $subjectPlan->attendance;
        $subjectPlan->middle = $request->middle ?? $subjectPlan->middle;
        $subjectPlan->ending = $request->ending ?? $subjectPlan->ending;
        $subjectPlan->etc = $request->etc ?? $subjectPlan->etc;
        $subjectPlan->attendance_mark = $request->attendance_mark ?? $subjectPlan->attendance_mark;
        $subjectPlan->middle_mark = $request->middle_mark ?? $subjectPlan->middle_mark;
        $subjectPlan->ending_mark = $request->ending_mark ?? $subjectPlan->ending_mark;
        $subjectPlan->etc_mark = $request->etc_mark ?? $subjectPlan->etc_mark;

        $subjectPlan->save();

        if(count($request->subject_plan_topics)){
            $subjectPlanTopicsData = [];
            foreach ($request->subject_plan_topics as $subject_plan_topic) {
                if(isset($subject_plan_topic['id'])){
                    $subjectPlanTopic = SubjectPlanTopic::find($subject_plan_topic['id']);
                    
                        $subjectPlanTopic->date = $subject_plan_topic['date'];
                        $subjectPlanTopic->topic = $subject_plan_topic['topic'];
                        $subjectPlanTopic->remark = $subject_plan_topic['remark'];
                }else{
                    $subjectPlanTopicsData[] = [
                        'subject_id' => $subjectPlan->subject_id,
                        'date' => $subject_plan_topic['date'],
                        'topic' => $subject_plan_topic['topic'],
                        'remark' => $subject_plan_topic['remark']
                    ];
                }
            }

            if(count($request->removeSPT)){
                foreach ($request->removeSPT as $removeSPT) {
                    if(isset($removeSPT['id'])){
                        $deleteTopic = SubjectPlanTopic::find($removeSPT['id']);
                        if($deleteTopic)
                            $deleteTopic->delete(); 
                    }
                }
            }

            $subjectPlan->subjectPlanTopics()->createMany($subjectPlanTopicsData);
        }

        return new SubjectPlanResource($subjectPlan);
    }

    public function subjectPlanBySemister(Subject $subject, Semester $semester)
    {
        $subjectPlan = SubjectPlan::where('subject_id', $subject->id)->where('semester_id', $semester->id)->with('subject','subjectPlanTopics')->first();
        if ($subjectPlan)
            return new SubjectPlanResource($subjectPlan);

        return null;
    }
}
