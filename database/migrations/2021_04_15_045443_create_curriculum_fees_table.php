<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('semester_id');
            $table->unsignedInteger('curriculum_id');
            $table->unsignedInteger('grade');
            $table->float('subject_fee')->default(0);
            $table->float('orientation_fee')->default(0);
            $table->float('others_fee')->default(0);
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
        Schema::dropIfExists('curriculum_fees');
    }
}
