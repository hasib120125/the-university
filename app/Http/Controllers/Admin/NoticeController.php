<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        return NoticeResource::collection(executeQuery(Notice::query()->latest()));
    }

    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'subject' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
            'status' => 'required|boolean',
        ]);

        $notice = Notice::create([
            'subject' => $request->subject,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
            'attachment1_original_filename' => $request->file('attachment1') ? $request->file('attachment1')->getClientOriginalName() : null,
            'attachment2_original_filename' => $request->file('attachment2') ? $request->file('attachment2')->getClientOriginalName() : null,
            'attachment1' => $request->file('attachment1') ? $request->file('attachment1')->store('notice_attachments') : null,
            'attachment2' => $request->file('attachment2') ? $request->file('attachment2')->store('notice_attachments') : null,
        ]);

        return new NoticeResource($notice);
    }

    public function show(Notice $notice)
    {
        return new NoticeResource($notice);
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'subject' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
            'attachment1' => 'nullable|file',
            'attachment2' => 'nullable|file',
            'status' => 'required|boolean',
        ]);

        $notice->subject = $request->subject;
        $notice->category = $request->category;
        $notice->description = $request->description;
        $notice->status = $request->status;
        $notice->attachment1_original_filename = $request->file('attachment1') ? $request->file('attachment1')->getClientOriginalName() : $notice->attachment1_original_filename;
        $notice->attachment2_original_filename = $request->file('attachment2') ? $request->file('attachment2')->getClientOriginalName() : $notice->attachment2_original_filename;
        $notice->attachment1 = $request->file('attachment1') ? $request->file('attachment1')->store('notice_attachments') : $notice->attachment1;
        $notice->attachment2 = $request->file('attachment2') ? $request->file('attachment2')->store('notice_attachments') : $notice->attachment2;
        $notice->save();

        return new NoticeResource($notice);
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
