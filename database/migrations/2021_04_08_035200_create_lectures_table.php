<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('room');
            $table->string('class');
            $table->unsignedInteger('day');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->float('weekly_hour');
            $table->unsignedInteger('weekly_num');
            $table->unsignedInteger('participants');
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedBigInteger('professor_id');
            $table->string('course_objective')->nullable();
            $table->string('lecture_outline')->nullable();
            $table->string('textbook')->nullable();
            $table->string('reference_book')->nullable();
            $table->string('evaluation_standard')->nullable();
            $table->float('attendance')->nullable();
            $table->float('middle')->nullable();
            $table->float('ending')->nullable();
            $table->float('etc')->nullable();
            $table->boolean('pass');
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
        Schema::dropIfExists('lectures');
    }
}
