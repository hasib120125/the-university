<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProfessorSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('professor_subject');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('professor_subject', function (Blueprint $table) {
            $table->unsignedInteger('professor_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('semester_id');
        });
    }
}
