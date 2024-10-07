<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaithsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faiths', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->string('name');
            $table->string('location');
            $table->string('office');
            $table->string('denomination');
            $table->string('year_of_faith');
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
        Schema::dropIfExists('faiths');
    }
}
