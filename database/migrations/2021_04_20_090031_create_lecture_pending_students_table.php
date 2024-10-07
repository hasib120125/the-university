<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturePendingStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('lecture_pending_students', function (Blueprint $table) {
            $table->integer('lecture_id');
            $table->integer('student_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lecture_pending_students');
    }
}
