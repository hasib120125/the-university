<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentOfPastoralMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_of_pastoral_music', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ko');
            $table->longText('content_en');
            $table->longText('content_ko');
            $table->softDeletes();
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
        Schema::dropIfExists('department_of_pastoral_music');
    }
}
