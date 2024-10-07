<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectExamStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lecture_exam_student');
        
        Schema::create('subject_exam_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_exam_id');
            $table->unsignedBigInteger('student_id');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_exam_student');
    }
}
