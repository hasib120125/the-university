<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lecture_assignments');
        
        Schema::create('subject_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('semester_id');
            $table->string('assignment_title');
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedInteger('task_type')->comment('1 for general task, 2 Assignment type test, 3 for Etc');
            $table->unsignedInteger('end_open')->comment('1 for Submission allowed, 2 Prohibited to submit');
            $table->longText('description')->nullable();
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
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
        Schema::dropIfExists('subject_assignments');
    }
}
