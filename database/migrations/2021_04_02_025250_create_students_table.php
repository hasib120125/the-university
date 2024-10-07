<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_no');
            $table->string('name_hangul');
            $table->string('name_chinese');
            $table->string('name_english');
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address');
            $table->unsignedBigInteger('curriculum_id');
            $table->unsignedInteger('grade');
            $table->string('citizenship_no');
            $table->date('dob');
            $table->string('mobile');
            $table->date('last_education_start');
            $table->date('last_education_end');
            $table->string('last_school_name');
            $table->string('graduate_plan');
            $table->string('last_education_department');
            $table->string('last_education_special');
            $table->string('motive');
            $table->string('job_company');
            $table->string('job_position');
            $table->string('job_address');
            $table->longText('remark')->nullable();
            $table->boolean('status');
            $table->string('degree_number');
            $table->date('withdrawal_date')->nullable();
            $table->date('admission_date');
            $table->date('graduation_date')->nullable();
            $table->unsignedBigInteger('professor_id');
            $table->boolean('admit_status');
            $table->boolean('bible_exam');
            $table->string('point_value')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
