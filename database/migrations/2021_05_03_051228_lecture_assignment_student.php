<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LectureAssignmentStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_subject_assignment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_assignment_id');
            $table->unsignedBigInteger('student_id');
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
            $table->unsignedInteger('status')->default(0)->comment('0=pending, 1=approve, 2=reject');
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
        Schema::dropIfExists('student_subject_assignment');
    }
}
