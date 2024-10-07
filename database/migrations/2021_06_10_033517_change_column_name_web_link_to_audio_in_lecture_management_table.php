<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNameWebLinkToAudioInLectureManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_management', function (Blueprint $table) {
            $table->renameColumn('web_link', 'audio');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_management', function (Blueprint $table) {
            $table->renameColumn('audio', 'web_link');
            $table->unsignedInteger('type')->comment('1 for web link, 2 for video, 3 for audio');
        });
    }
}
