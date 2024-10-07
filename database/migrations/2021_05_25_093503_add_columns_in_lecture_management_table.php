<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInLectureManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_management', function (Blueprint $table) {
            $table->string('original_video')->after('type')->nullable();
            $table->unsignedInteger('duration')->after('original_video')->nullable();
            $table->string('smil')->after('duration')->nullable();
            $table->string('q_480')->after('smil')->nullable();
            $table->string('q_720')->after('q_480')->nullable();
            $table->string('q_1080')->after('q_720')->nullable();
            $table->string('convert_status')->after('q_1080')->nullable();
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
            $table->dropColumn('original_video');
            $table->dropColumn('duration');
            $table->dropColumn('smil');
            $table->dropColumn('q_480');
            $table->dropColumn('q_720');
            $table->dropColumn('q_1080');
            $table->dropColumn('convert_status');
        });
    }
}
