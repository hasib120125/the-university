<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->integer('season');
            $table->string('code');
            $table->dateTime('course_reg_start');
            $table->dateTime('course_reg_end');
            $table->dateTime('tuition_reg_start');
            $table->dateTime('tuition_reg_end');
            $table->dateTime('application_start');
            $table->dateTime('application_end');
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
        Schema::dropIfExists('semesters');
    }
}
