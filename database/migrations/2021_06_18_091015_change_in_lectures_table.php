<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lectures');

        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('semester_id');
            $table->date('start_period');
            $table->date('end_period');
            $table->longText('description')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('audio_duration')->nullable();
            $table->string('original_video_file')->nullable();
            $table->string('thumbs')->nullable();
            $table->string('original_video')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->string('smil')->nullable();
            $table->string('q_480')->nullable();
            $table->string('q_720')->nullable();
            $table->string('q_1080')->nullable();
            $table->string('convert_status')->nullable();
            $table->boolean('status')->default(1);
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
