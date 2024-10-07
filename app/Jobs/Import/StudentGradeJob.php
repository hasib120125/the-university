<?php

namespace App\Jobs\Import;

use App\Models\Student;
use App\Models\StudentGrade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StudentGradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $scores;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($scores)
    {
        $this->onQueue('score');
        $this->scores = $scores;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->scores as $score){
            $query = StudentGrade::where('student_no', $score->STUDENT_CODE)->where('semester_code', $score->SEM_CODE);
            if($score->lecture){
                $query->where('subject_name', $score->lecture->TITLE);
            }

            $studentGrade = $query->first();

            if(!$studentGrade) $studentGrade = new StudentGrade();
            $student = Student::where('student_no',$score->STUDENT_CODE)->first();
            if($student){
                $semesterData = str_split($score->SEM_CODE, 4);
                $studentGrade->subject_name = $score->lecture ? $score->lecture->TITLE : '';
                $studentGrade->credit = $score->lecture ? $score->lecture->SCORE : 0;
                $studentGrade->student_id = $student->id;
                $studentGrade->student_no = $student->student_no;
                $studentGrade->semester_code =  $score->SEM_CODE;
                $studentGrade->semester_year =  $semesterData[0];
                $studentGrade->semester_season = $semesterData[1];
                $studentGrade->attendance = $score->ATTENDANCE;
                $studentGrade->middle = $score->MIDDLE_SCORE;
                $studentGrade->ending = $score->LAST_SCORE;
                $studentGrade->etc = $score->ETC;
                $studentGrade->score = $score->TOTAL_SCORE;
                $studentGrade->grades = $score->AVERAGE_SCORE;
                $studentGrade->grade = $score->GRADE;
                $studentGrade->save();
            }
        }
    }
}
