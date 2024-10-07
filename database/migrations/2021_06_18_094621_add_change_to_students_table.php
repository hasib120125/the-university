<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('curriculum_id');
            $table->unsignedBigInteger('department_id')->after('address');
            $table->unsignedBigInteger('semester_id')->after('department_id');
            $table->dropColumn('grade');
            $table->dropColumn('reg_year');
            $table->dropColumn('reg_season');
            $table->dropColumn('professor_id');
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
            $table->unsignedBigInteger('curriculum_id');
            $table->dropColumn('department_id');
            $table->dropColumn('semester_id');
            $table->unsignedInteger('grade');
            $table->string('reg_year');
            $table->unsignedInteger('reg_season');
            $table->unsignedBigInteger('professor_id');
        });
    }
}
