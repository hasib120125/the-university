<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        return ApplicationResource::collection(executeQuery(Application::query()->where('student_id', Auth::guard('student')->user()->id)->with('attachments')));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string',
            'files' => 'required|array'
        ]);

        $data['student_id'] = Auth::guard('student')->user()->id;
        $data['status'] = 1;

        $application = Application::create($data);

        for($i=0; $i < count($request->input('files')); $i++) {
            $applicationAttachment = new ApplicationAttachment();
            $applicationAttachment->application_id = $application->id;
            $applicationAttachment->file = $request->input('files')[$i];
            $applicationAttachment->file_name = $request->input('originalFiles')[$i] ? $request->input('originalFiles')[$i] : null;
            $applicationAttachment->save();
        }

        return new ApplicationResource($application);
    }

}
