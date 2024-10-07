<?php

namespace App\Jobs\Import;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StudentAdmissionDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $students;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->students as $singleStudent){
            if($singleStudent->ENTER_DATE){
                $student = Student::where('student_no', $singleStudent->MB_CODE)->first();

                if($student){
                    $ENTER_DATE = explode(".",$singleStudent->ENTER_DATE);
                    if(count($ENTER_DATE) > 1){
                        $singleStudent->ENTER_DATE = implode('-', $ENTER_DATE);
                    }
                    $student->admission_date = $singleStudent->ENTER_DATE;
                    if($singleStudent->GRADU_DATE){
                        if(strlen($singleStudent->GRADU_DATE) > 10){
                            $singleStudent->GRADU_DATE = explode("(",$singleStudent->GRADU_DATE)[0];
                        }

                        $GRADU_DATE = explode(".",$singleStudent->GRADU_DATE);
                        if(count($GRADU_DATE) > 1){
                            $singleStudent->GRADU_DATE = implode('-', $GRADU_DATE);
                        }

                        $student->graduation_date =  $singleStudent->GRADU_DATE;
                    }
                    $student->save();
                }
            }

        }
    }
}
