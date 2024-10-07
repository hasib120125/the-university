<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletedAtColumnInLectureManagementProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecture_management_progress', function (Blueprint $table) {
            $table->timestamp('completed_at')->after('late')->nullable();
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
            $table->dropColumn('completed_at');
        });
    }
}
