<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnInLectureManagementProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_management_progress', function (Blueprint $table) {
            $table->string('type')->after('lecture_management_id');
            $table->boolean('completed')->after('progress_percentage')->default(0);
            $table->boolean('late')->after('completed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecture_management_progress', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('completed');
            $table->dropColumn('late');
        });
    }
}
