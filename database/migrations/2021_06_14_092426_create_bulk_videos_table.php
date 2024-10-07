<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_videos', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->string('original_video')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->string('thumbs')->nullable();
            $table->string('smil')->nullable();
            $table->string('q_480')->nullable();
            $table->string('q_720')->nullable();
            $table->string('q_1080')->nullable();
            $table->string('convert_status')->nullable();
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
        Schema::dropIfExists('bulk_videos');
    }
}
