<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id');
            $table->string('test_title');
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedInteger('time_limit')->comment('exam duration');
            $table->unsignedInteger('number_of_question');
            $table->float('marks_per_question');
            $table->unsignedInteger('exam_type')->comment('1 for Midterm exam, 2 for Finals, 3 for Bible test');
            $table->unsignedInteger('submitter_id')->comment('professor id');
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
        Schema::dropIfExists('lecture_exams');
    }
}
