<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectNameSemesterCodeInStudentGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_grades', function (Blueprint $table) {
            $table->string('subject_name')->nullable()->after('subject_id');
            $table->string('credit')->nullable()->after('subject_id');
            $table->string('semester_code')->nullable()->after('semester_id');
            $table->string('semester_year')->nullable()->after('semester_id');
            $table->string('semester_season')->nullable()->after('semester_id');
            $table->string('student_no')->nullable()->after('student_id');
            $table->unsignedInteger('student_id')->nullable()->change();
            $table->unsignedInteger('semester_id')->nullable()->change();
            $table->unsignedInteger('subject_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_grades', function (Blueprint $table) {
            $table->dropColumn(['subject_name', 'semester_code', 'semester_year' , 'semester_season' , 'student_no', 'credit']);
        });
    }
}
