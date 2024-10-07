<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTuitionFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_tuition_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->float('tuition_fee')->default(0);
            $table->float('enterance_fee')->default(0);
            $table->float('seminar_fee')->default(0);
            $table->float('student_union_fee')->default(0);
            $table->float('orientation_fee')->default(0);
            $table->float('deduction')->default(0);
            $table->float('scholarship')->default(0);
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
        Schema::dropIfExists('student_tuition_fees');
    }
}
