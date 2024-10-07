<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectPlanTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_plan_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_plan_id');
            $table->unsignedBigInteger('subject_id');
            $table->date('date')->nullable();
            $table->string('topic');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('subject_plan_topics');
    }
}
