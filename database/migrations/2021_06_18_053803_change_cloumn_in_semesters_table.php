<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCloumnInSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('course_reg_start');
            $table->dropColumn('course_reg_end');
            $table->dropColumn('tuition_reg_start');
            $table->dropColumn('tuition_reg_end');
            $table->dropColumn('application_start');
            $table->dropColumn('application_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->string('code');
            $table->date('course_reg_start');
            $table->date('course_reg_end');
            $table->date('tuition_reg_start');
            $table->date('tuition_reg_end');
            $table->date('application_start');
            $table->date('application_end');
        });
    }
}
