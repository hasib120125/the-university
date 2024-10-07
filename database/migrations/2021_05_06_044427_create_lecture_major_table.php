<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureMajorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_major', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_id');
            $table->unsignedBigInteger('lecture_id');
            $table->boolean('grade_year_1')->nullable()->default(0);
            $table->boolean('grade_year_2')->nullable()->default(0);
            $table->boolean('grade_year_3')->nullable()->default(0);
            $table->boolean('grade_year_4')->nullable()->default(0);
            $table->float('grade')->default(0)->nullable()->comment('will be in point');
            $table->unsignedInteger('major_category')->default(1)->comment('1=Common essentials, 2=Major required, 3=Selection');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecture_major');
    }
}
