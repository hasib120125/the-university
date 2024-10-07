<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureQASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_qas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_id');
            $table->unsignedBigInteger('lecture_management_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedInteger('type')->nullable()->comment('1 for lecture content, 2 for something else');
            $table->text('title')->nullable();
            $table->longText('details')->nullable();
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
        Schema::dropIfExists('lecture_qas');
    }
}
