<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lecture_weeks');

        Schema::create('subject_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('semester_id');
            $table->string('subject_outline')->nullable();
            $table->string('textbook')->nullable();
            $table->string('reference_book')->nullable();
            $table->string('evaluation_standard')->nullable();
            $table->float('attendance')->nullable();
            $table->float('middle')->nullable();
            $table->float('ending')->nullable();
            $table->float('etc')->nullable();
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
        Schema::dropIfExists('subject_plans');
    }
}
