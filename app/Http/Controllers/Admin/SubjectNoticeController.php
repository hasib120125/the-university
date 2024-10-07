<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectNoticeResource;
use App\Models\Subject;
use App\Models\SubjectNotice;
use Illuminate\Http\Request;

class SubjectNoticeController extends Controller
{
    public function index(Subject $subject, Request $request)
    {
        $query = $subject->notices();

        if ($request->semester_id)
            $query->where('semester_id', $request->semester_id);

        return SubjectNoticeResource::collection(executeQuery($query));
    }

    public function store(Request $request, Subject $subject)
    {
        $request->validate([
            'title' => 'required|string',
            'semester_id' => 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $notice = $subject->notices()->create([
            'title' => $request->title,
            'semester_id' => $request->semester_id,
            'description' => $request->description,
            'attachment1_original_filename' => $request->file('attachment1') ? $request->file('attachment1')->getClientOriginalName() : null,
            'attachment2_original_filename' => $request->file('attachment2') ? $request->file('attachment2')->getClientOriginalName() : null,
            'attachment1' => $request->file('attachment1') ? $request->file('attachment1')->store('subject_notice_attachments') : null,
            'attachment2' => $request->file('attachment2') ? $request->file('attachment2')->store('subject_notice_attachments') : null,
        ]);

        return new SubjectNoticeResource($notice);
    }

    public function show(Subject $subject, SubjectNotice $notice)
    {
        return new SubjectNoticeResource($notice);
    }

    public function update(Request $request, Subject $subject, SubjectNotice $notice)
    {
        $request->validate([
            'title' => 'required|string',
            'semester_id' => 'required|integer',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
        ]);

        $notice->title = $request->title;
        $notice->semester_id = $request->semester_id;
        $notice->description = $request->description;
        $notice->attachment1_original_filename = $request->file('attachment1') ? $request->file('attachment1')->getClientOriginalName() : $notice->attachment1_original_filename;
        $notice->attachment2_original_filename = $request->file('attachment2') ? $request->file('attachment2')->getClientOriginalName() : $notice->attachment2_original_filename;
        $notice->attachment1 = $request->file('attachment1') ? $request->file('attachment1')->store('subject_notice_attachments') : $notice->attachment1;
        $notice->attachment2 = $request->file('attachment2') ? $request->file('attachment2')->store('subject_notice_attachments') : $notice->attachment2;
        $notice->save();

        return new SubjectNoticeResource($notice);
    }

    public function destroy(Subject $subject, SubjectNotice $notice)
    {
        $notice->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
