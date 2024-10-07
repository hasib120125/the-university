<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('lecture_number');
            $table->string('lecture_name');
            $table->string('web_link')->nullable();
            $table->string('file')->nullable();
            $table->time('video_running_time')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedInteger('type')->comment('1 for web link, 2 for video, 3 for audio');
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
        Schema::dropIfExists('lecture_management');
    }
}
