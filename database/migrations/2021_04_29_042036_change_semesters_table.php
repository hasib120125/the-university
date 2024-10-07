<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->date('course_reg_start')->change();
            $table->date('course_reg_end')->change();
            $table->date('tuition_reg_start')->change();
            $table->date('tuition_reg_end')->change();
            $table->date('application_start')->change();
            $table->date('application_end')->change();
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
            $table->dateTime('course_reg_start')->change();
            $table->dateTime('course_reg_end')->change();
            $table->dateTime('tuition_reg_start')->change();
            $table->dateTime('tuition_reg_end')->change();
            $table->dateTime('application_start')->change();
            $table->dateTime('application_end')->change();
        });
    }
}
