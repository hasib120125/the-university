<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeToNullableInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->date('dob')->nullable()->change();
            $table->date('last_education_start')->nullable()->change();
            $table->date('last_education_start')->nullable()->change();
            $table->date('last_education_end')->nullable()->change();
            $table->string('last_school_name')->nullable()->change();
            $table->string('graduate_plan')->nullable()->change();
            $table->string('last_education_department')->nullable()->change();
            $table->string('last_education_special')->nullable()->change();
            $table->string('degree_number')->nullable()->change();
            $table->string('job_company')->nullable()->change();
            $table->string('citizenship_no')->nullable()->change();
            $table->date('admission_date')->nullable()->change();
            $table->unsignedInteger('admit_status')->nullable()->change();
            $table->boolean('bible_exam')->nullable()->change();
            $table->unsignedInteger('status')->nullable()->change();
            $table->unsignedInteger('department_id')->nullable()->change();
            $table->unsignedInteger('semester_id')->nullable()->change();
            $table->string('church_name')->after('leave_start_date')->nullable();
            $table->string('zip_code')->after('leave_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->date('dob')->change();
            $table->date('last_education_start')->change();
            $table->date('last_education_end')->change();
            $table->string('last_school_name')->change();
            $table->string('graduate_plan')->change();
            $table->string('last_education_department')->change();
            $table->string('last_education_special')->change();
            $table->string('degree_number')->change();
            $table->string('job_company')->change();
            $table->string('citizenship_no')->change();
            $table->date('admission_date')->change();
            $table->unsignedInteger('admit_status')->change();
            $table->boolean('bible_exam')->change();
            $table->unsignedInteger('status')->change();
            $table->unsignedInteger('department_id')->change();
            $table->unsignedInteger('semester_id')->change();
            $table->dropColumn('church_name');
            $table->dropColumn('zip_code');
        });
    }
}
