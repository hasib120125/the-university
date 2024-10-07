<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedInteger('grade')->nullable()->change();
            $table->string('graduate_plan')->nullable()->change();
            $table->boolean('status')->nullable()->change();
            $table->string('degree_number')->nullable()->change();
            $table->date('admission_date')->nullable()->change();
            $table->unsignedBigInteger('professor_id')->nullable()->change();
            $table->boolean('bible_exam')->nullable()->change();
            $table->string('gender')->after('password')->nullable();
            $table->integer('admit_status')->nullable()->change();
            $table->string('phone')->after('mobile')->nullable();
            $table->boolean('status')->default(0)->change();
            $table->string('confention_faith_file')->after('photo')->nullable();
            $table->string('study_plan')->after('photo')->nullable();
            $table->string('theological_dissertation_file')->after('photo')->nullable();
            $table->string('job_position')->nullable()->change();
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
            $table->unsignedInteger('grade')->change();
            $table->string('graduate_plan')->change();
            $table->boolean('status')->change();
            $table->string('degree_number')->change();
            $table->date('admission_date')->change();
            $table->unsignedBigInteger('professor_id')->change();
            $table->boolean('bible_exam')->change();
            $table->dropColumn('gender');
            $table->integer('admit_status')->change();
            $table->dropColumn('phone');
            $table->boolean('status')->change();
            $table->boolean('job_position')->change();
        });
    }
}
