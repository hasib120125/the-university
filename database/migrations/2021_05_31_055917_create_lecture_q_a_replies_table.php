<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureQARepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_qa_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_qa_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('user_type')->nullable()->comment('1 for admin, 2 for student');
            $table->longText('reply')->nullable();
            $table->unsignedInteger('like')->default(0);
            $table->longText('liked_users')->nullable();
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
        Schema::dropIfExists('lecture_qa_replies');
    }
}
