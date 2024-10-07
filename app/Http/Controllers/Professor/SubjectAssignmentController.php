<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectAssignmentResource;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\StudentAssignmentSubmitResource;
use App\Models\Subject;
use App\Models\SubjectAssignment;
use App\Models\Student;
use Illuminate\Http\Request;

class SubjectAssignmentController extends Controller
{
    public function index(Subject $subject, Request $request)
    {
        $query = $subject->assignments();

        if ($request->semester_id)
            $query->where('semester_id', $request->semester_id);

        return SubjectAssignmentResource::collection(executeQuery($query));
    }

    public function store(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'semester_id' => 'required|integer|exists:semesters,id',
            'assignment_title' => 'required|string',
            'start_period'=> 'required|date',
            'end_period'=> 'required|date|after_or_equal:start_period',
            'task_type'=> 'required|integer',
            'end_open'=> 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $data['attachment1'] = $request->file('attachment1') ? $request->file('attachment1')->store('assignment_attachments') : null;
        $data['attachment2'] = $request->file('attachment2') ? $request->file('attachment2')->store('assignment_attachments') : null;

        $assignment = $subject->assignments()->create($data);

        return new SubjectAssignmentResource($assignment);
    }

    public function show(Subject $subject, SubjectAssignment $assignment)
    {
        return new SubjectAssignmentResource($assignment);
    }

    public function update(Request $request, Subject $subject, SubjectAssignment $assignment)
    {
        $request->validate([
            'assignment_title' => 'required|string',
            'start_period'=> 'required|date',
            'end_period'=> 'required|date|after_or_equal:start_period',
            'task_type'=> 'required|integer',
            'end_open'=> 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $assignment->assignment_title = $request->assignment_title;
        $assignment->start_period = $request->start_period;
        $assignment->end_period = $request->end_period;
        $assignment->task_type = $request->task_type;
        $assignment->end_open = $request->end_open;
        $assignment->description = $request->description;
        $assignment->attachment1 = $request->file('attachment1') ? $request->file('attachment1')->store('assignment_attachments') : $assignment->attachment1;
        $assignment->attachment2 = $request->file('attachment2') ? $request->file('attachment2')->store('assignment_attachments') : $assignment->attachment2;
        $assignment->save();

        return new SubjectAssignmentResource($assignment);
    }

    public function destroy(Subject $subject, SubjectAssignment $assignment)
    {
        $assignment->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }

    public function students(SubjectAssignment $assignment)
    {
        return StudentAssignmentSubmitResource::collection(executeQuery($assignment->studentAssignmentSubmit()->with('student', 'attachments')));
    }

    public function approveOrReject(Request $request, SubjectAssignment $assignment, Student $student)
    {
        $student->submittedAssignments()->where('subject_assignment_id', $assignment->id)->update(['status'=> $request->status]);

        return StudentAssignmentSubmitResource::collection(executeQuery($assignment->studentAssignmentSubmit()));
    }

}
