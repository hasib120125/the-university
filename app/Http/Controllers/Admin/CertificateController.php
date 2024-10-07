<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Transcript;
use App\PageBuilder\TranscriptPageBuilder;
use PDF;

class CertificateController extends Controller
{
    public function generateCertificate(Student $student)
    {
        $totalIssue = Certificate::count();

        $issueNumber = 'ICS' .date('Y-') . str_pad( $totalIssue + 1 , 3, '0', STR_PAD_LEFT);

        Certificate::create(['issue_no'=> $issueNumber, 'student_id'=> $student->id]);

        $student->load('department');

        $studentData = [
            'issue_no' => $issueNumber,
            'name' => $student->name_hangul,
            'dob' => $student->dob ? $student->dob->format('Y') .'년' .$student->dob->format('m').'월' . $student->dob->format('d') . '일': '',
            'admission_date' => $student->admission_date ? $student->admission_date->format('Y') .'년' .$student->admission_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'graduation_date' => $student->graduation_date ? $student->graduation_date->format('Y') .'년' .$student->graduation_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'department' => $student->department ? $student->department->name : '',
            'degree' => $student->department ? $student->department->degree : '',
            'issue_date' =>  date('Y') .'년' .date('m').'월' . date('d') . '일'
        ];

        // return view('pdf.certificate', ['student'=> $studentData]);
        $pdf = PDF::loadView('pdf.certificate', ['student'=> $studentData]);

        return $pdf->download('certificate.pdf');
        // return $pdf->stream();

    }

//    public function generateTranscript(Student $student)
    public function generateTranscript(Student $student)
    {
        $student->load('department');

        $semesterWiseGrades = StudentGrade::where('student_id', $student->id)->orderBy('semester_code')->get()->groupBy('semester_code')->toArray();

        $gradeSystem = Grade::all();

        $totalIssue = Transcript::count();

        $issueNumber = 'ICS' .date('Y-') . str_pad( $totalIssue + 1 , 3, '0', STR_PAD_LEFT);

        Transcript::create(['issue_no'=> $issueNumber, 'student_id'=> $student->id]);

        $studentData = [
            'issueNumber' => $issueNumber,
            'name' => $student->name_hangul,
            'dob' => $student->dob ? $student->dob->format('Y') .'년' .$student->dob->format('m').'월' . $student->dob->format('d') . '일': '',
            'department' => $student->department ? $student->department->name : '',
            'degree' => $student->department ? $student->department->degree : '',
            'student_id' => $student->student_no ? $student->student_no : '',
            'gender' => $student->gender ? $student->gender : '',
            'admission_date' => $student->admission_date ? $student->admission_date->format('Y') .'년' .$student->admission_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'graduation_date' => $student->graduation_date ? $student->graduation_date->format('Y') .'년' .$student->graduation_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'allSemester' => $semesterWiseGrades,
            'gradeSystem' => $gradeSystem,
        ];


        $pageBuilder = new TranscriptPageBuilder();
        $pages = $pageBuilder->getPages($studentData);

//        return view('pdf.transcript',compact('pages'));
//
//        return $pages;

        $pdf = PDF::loadView('pdf.transcript', compact('pages'));
        return $pdf->download('transcript.pdf');

        return $pdf->stream();
        return view('pdf.transcript',compact('studentData'));
    }
}
