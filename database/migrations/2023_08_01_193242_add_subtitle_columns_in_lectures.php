<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtitleColumnsInLectures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->unsignedBigInteger('bulk_subtitle_id')->after('bulk_video_id')->nullable();
            $table->string('subtitle_file')->after('audio_duration')->nullable();
            $table->string('subtitle_label')->after('subtitle_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn('bulk_subtitle_id');
            $table->dropColumn('subtitle_file');
            $table->dropColumn('subtitle_label');
        });
    }
}
