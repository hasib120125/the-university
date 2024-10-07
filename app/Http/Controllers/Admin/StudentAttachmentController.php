<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAttachmentResource;
use App\Models\Student;
use App\Models\StudentAttachment;
use Illuminate\Http\Request;

class StudentAttachmentController extends Controller
{
    public function index(Student $student)
    {
        return StudentAttachmentResource::collection(executeQuery($student->attachments()));
    }

    public function store(Request $request, Student $student)
    {
        return $student->attachments()->count();
        
        $request->validate([
            'attachment' => 'required|file',
        ]);

        $attachment = $student->attachments()->create(
            [
                'orginal_name' => $request->file('attachment') ? $request->file('attachment')->getClientOriginalName() : null,
                'attachment' => $request->file('attachment') ? $request->file('attachment')->store('student_attachments') : null,
            ]
        );

        return new StudentAttachmentResource($attachment);
    }

    public function destroy( Student $student ,StudentAttachment $studentAttachment)
    {
        $studentAttachment->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
