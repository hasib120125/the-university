<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Student;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function studentApplications(Student $student)
    {
        return ApplicationResource::collection(executeQuery(Application::query()->where('student_id', $student->id)->with('attachments')));
    }

    public function pendingApplication()
    {
        return ApplicationResource::collection(executeQuery(Application::query()->where('status', 1)->with('attachments')));
    }

    public function approveOrReject(Request $request, Application $application)
    {
        $application->update(['status'=> $request->status]);

        return new ApplicationResource($application);
    }
}
