<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function index()
    {
        $this->semesters();
        return 'done';
    }

    public function semesters()
    {
        $semesters = DB::connection('old')->table("waics_lms_dbo_semester")->get();
        foreach ($semesters as $semester){
            $cSemester = Semester::where('semester_code', $semester->SEM_CODE)->withTrashed()->first();

            if($cSemester) continue;

            $data = [
                'semester_code'=> $semester->SEM_CODE,
                'year'=> $semester->SEM_YEAR,
                'season'=> $semester->SEMESTER,
                'start_period'=> date('Y-m-d', strtotime($semester->LEC_ATTEND_S)),
                'end_period'=> date('Y-m-d', strtotime($semester->LEC_ATTEND_E))
                ];

            Semester::create($data);
        }

    }
}
