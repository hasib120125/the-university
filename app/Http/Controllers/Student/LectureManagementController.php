<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureManagementProgressResource;
use App\Http\Resources\LectureManagementResource;
use App\Models\Lecture;
use App\Models\LectureManagement;
use App\Models\LectureManagementProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LectureManagementController extends Controller
{
    public function index(Lecture $lecture)
    {
        return LectureManagementResource::collection(executeQuery(
            LectureManagement::query()
                ->where('lecture_id', $lecture->id)
                ->with('progress')
                ->orderBy('created_at', 'desc')
            ));
    }

    public function show(Lecture $lecture, LectureManagement $management)
    {
        return new LectureManagementResource($management);
    }
}
