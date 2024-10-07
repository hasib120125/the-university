<?php

namespace App\Http\Controllers\Front;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Models\OfflineSeminar;
use App\Models\ArticlePublication;
use App\Http\Controllers\Controller;
use App\Http\Resources\DownloadResource;
use App\Http\Resources\OfflineSeminarResource;
use App\Http\Resources\AcademicRegulationResource;
use App\Http\Resources\AdmissionCounsellingResource;
use App\Http\Resources\ArticlePublicationsResource;
use App\Http\Resources\DepartmentOfMissiologyResource;
use App\Http\Resources\DepartmentOfPastoralMusicResource;
use App\Http\Resources\MinistryofMinistryResource;
use App\Http\Resources\Professor\ProfessorResource;
use App\Models\AcademicRegulation;
use App\Models\AdmissionCounselling;
use App\Models\CustomSubject;
use App\Models\Department;
use App\Models\DepartmentOfMissiology;
use App\Models\DepartmentOfPastoralMusic;
use App\Models\MinistryofMinistry;
use App\Models\Professor;
use App\Models\Subject;

class FixedPageController extends Controller
{
    public function admissionCounselling()
    {
        return AdmissionCounsellingResource::collection(AdmissionCounselling::latest()->paginate(5));
    }

    public function academicRegulation()
    {
        return AcademicRegulationResource::collection(AcademicRegulation::get());
    }

    public function ministryOfMinistry()
    {
        return MinistryofMinistryResource::collection(MinistryofMinistry::get());
    }

    public function departmentOfMissiology()
    {
        return DepartmentOfMissiologyResource::collection(DepartmentOfMissiology::get());
    }

    public function departmentOfPastoralMusic()
    {
        return DepartmentOfPastoralMusicResource::collection(DepartmentOfPastoralMusic::get());
    }

    public function professors()
    {
        $professors = Professor::whereNotNull('custom_subject_id')->get()->groupBy('custom_subject_id');
        $formattedProfessors = [];
        foreach ($professors as $key => $professor) {
            $subject = CustomSubject::find($key);
            $formattedProfessors[$subject->name] = ProfessorResource::collection($professor);
        }

        return $formattedProfessors;
    }

    public function articlePublications(Request $request)
    {
        return ArticlePublicationsResource::collection(ArticlePublication::paginate(10));
    }

    public function offlineSeminars(Request $request)
    {
        return OfflineSeminarResource::collection(OfflineSeminar::latest()->paginate(5));
    }

    public function downloads(Request $request)
    {
        return DownloadResource::collection(Download::latest()->paginate(10));
    }
}
