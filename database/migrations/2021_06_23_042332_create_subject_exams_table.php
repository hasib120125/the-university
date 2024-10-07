<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lecture_exams');
        
        Schema::create('subject_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('semester_id');
            $table->string('title');
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedInteger('time_limit')->comment('exam duration');
            $table->unsignedInteger('exam_type')->comment('1 for Midterm exam, 2 for Finals, 3 for Bible test');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_exams');
    }
}
