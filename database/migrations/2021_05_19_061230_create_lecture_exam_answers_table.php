<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_exam_id');
            $table->unsignedBigInteger('lecture_exam_question_id');
            $table->unsignedBigInteger('student_id');
            $table->boolean('correct')->nullable();
            $table->longText('answer');
            $table->float('score')->default(0)->nullable();
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
        Schema::dropIfExists('lecture_exam_answers');
    }
}
