<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('lecture_notices');

        Schema::create('subject_notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('subject_id');
            $table->longText('description');
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
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
        Schema::dropIfExists('subject_notices');
    }
}
