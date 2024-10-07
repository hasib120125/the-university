<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAssignmentSubmitResource;
use App\Http\Resources\SubjectAssignmentResource;
use App\Models\StudentAssignmentSubmit;
use App\Models\StudentSubjectAssignmentAttachment;
use App\Models\SubjectActiveStudent;
use App\Models\SubjectAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectAssignmentController extends Controller
{
    public function index(SubjectActiveStudent $subject)
    {
        $query = SubjectAssignment::query()->where('subject_id', $subject->subject_id)
            ->where('semester_id', $subject->semester_id)->latest();

        return SubjectAssignmentResource::collection(executeQuery($query));
    }

    public function show(SubjectActiveStudent $subject, SubjectAssignment $assignment)
    {
        $submittedAssignment = Auth::guard('student')->user()->submittedAssignments()->where('subject_assignment_id', $assignment->id)->with('attachments')->first();

        return [
            'assignment'=> new SubjectAssignmentResource($assignment ),
            'studentAssignmentSubmit'=> $submittedAssignment ? new StudentAssignmentSubmitResource($submittedAssignment) : null,
        ];
    }

    public function store(Request $request, SubjectAssignment $subject)//here $subject is $subjectAssignment
    {
        $request->validate([
            'attachment1' => 'required|file',
            'attachment2' => 'nullable|file',
        ]);
        
        if(!($subject->start_period->lte(Carbon::today()) && $subject->end_period->gte(Carbon::today())))
            return response()->json(['success' => false, 'message' => 'Assignment Submission date over.']);

        $student = Auth::guard('student')->user();
        $studentAssignmentSubmit = $student->submittedAssignments()->where('subject_assignment_id', $subject->id)->first();
        
        if(!$studentAssignmentSubmit){
            $studentAssignmentSubmit = StudentAssignmentSubmit::create([
                'student_id'=> $student->id, 
                'subject_assignment_id'=> $subject->id,
            ]);
        }

        $studentAssignmentSubmit->status = 0;
        $studentAssignmentSubmit->save();

        StudentSubjectAssignmentAttachment::create([
            'student_assignment_submit_id'=> $studentAssignmentSubmit->id,
            'file'=> $request->file('attachment1') ? $request->file('attachment1')->store('assignment_attachments') : null, 
            'file_name'=> $request->file('attachment1') ? $request->file('attachment1')->getClientOriginalName() : null
        ]);

        if($request->attachment2){
            StudentSubjectAssignmentAttachment::create([
                'student_assignment_submit_id'=> $studentAssignmentSubmit->id,
                'file'=> $request->file('attachment2') ? $request->file('attachment2')->store('assignment_attachments') : null, 
                'file_name'=> $request->file('attachment2') ? $request->file('attachment2')->getClientOriginalName() : null
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Assignment submitted successfully']);
    }

    public function deleteFile($fileId)
    {
        StudentSubjectAssignmentAttachment::destroy($fileId);

        return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    }

}
