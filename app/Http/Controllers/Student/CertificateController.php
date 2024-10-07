<?php

namespace App\Http\Controllers\Student;

use PDF;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\StudentGradeResource;

class CertificateController extends Controller
{
    public function printTranscript()
    {
        $student = Student::where('id', 1)->first();

        $student->load('department');

        $semesterWiseGrades = StudentGrade::with('semester', 'subject')->where('student_id', $student->id)->get()->groupBy('semester_id')->toArray();

        $gradeSystem = Grade::all();

        $studentData = [
            'issueNumber' => 'abc',
            'name' => $student->name_hangul,
            'dob' => $student->dob ? $student->dob->format('Y') .'년' .$student->dob->format('m').'월' . $student->dob->format('d') . '일': '',
            'department' => $student->department->name,
            'degree' => $student->department->degree,
            'student_id' => $student->student_no ? $student->student_no : '',
            'gender' => $student->gender ? $student->gender : '',
            'admission_date' => $student->admission_date ? $student->admission_date->format('Y') .'년' .$student->admission_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'graduation_date' => $student->graduation_date ? $student->graduation_date->format('Y') .'년' .$student->graduation_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'allSemister' => $semesterWiseGrades,
            'gradeSystem' => $gradeSystem,
        ];

        $pdf = PDF::loadView('pdf.transcript', compact('studentData'));

        return $pdf->stream();

        // return view('pdf.transcript',compact('studentData'));
    }

    public function printCertificate()
    {
        $student = Student::where('id', 1)->with('department')->first();

        $studentData = [
            'issue_no' => 'abc',
            'name' => $student->name_hangul,
            'dob' => $student->dob ? $student->dob->format('Y') .'년' .$student->dob->format('m').'월' . $student->dob->format('d') . '일': '',
            'admission_date' => $student->admission_date ? $student->admission_date->format('Y') .'년' .$student->admission_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'graduation_date' => $student->graduation_date ? $student->graduation_date->format('Y') .'년' .$student->graduation_date->format('m').'월' . $student->admission_date->format('d') . '일': '',
            'department' => $student->department->name,
            'degree' => $student->department->degree,
            'issue_date' =>  date('Y') .'년' .date('m').'월' . date('d') . '일'
        ];
        
        // return view('pdf.certificate', ['student'=> $studentData]);
        $pdf = PDF::loadView('pdf.certificate', ['student'=> $studentData]);

        // return $pdf->download('certificate.pdf');
        return $pdf->stream();
    }
}
