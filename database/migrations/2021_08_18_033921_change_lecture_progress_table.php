<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLectureProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_progress', function (Blueprint $table) {
            $table->renameColumn('current_time', 'audio_current_time');
            $table->renameColumn('total_time', 'audio_total_time');
            $table->renameColumn('progress_percentage', 'audio_progress_percentage');
            $table->unsignedInteger('video_current_time')->nullable()->after('current_time');
            $table->unsignedInteger('video_total_time')->nullable()->after('video_current_time');
            $table->unsignedInteger('video_progress_percentage')->nullable()->after('video_total_time');
            $table->string('current_content_type')->after('video_total_time');
        });

        Schema::table('lecture_progress', function (Blueprint $table) {
            $table->unsignedInteger('audio_current_time')->nullable()->change();
            $table->unsignedInteger('audio_total_time')->nullable()->change();
            $table->unsignedInteger('audio_progress_percentage')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_progress', function (Blueprint $table) {
            $table->renameColumn('audio_current_time', 'current_time');
            $table->renameColumn('audio_total_time', 'total_time');
            $table->renameColumn('audio_progress_percentage', 'progress_percentage');
            $table->dropColumn('video_current_time');
            $table->dropColumn('video_total_time');
            $table->dropColumn('video_progress_percentage');
            $table->dropColumn('current_content_type');
        });
    }
}
