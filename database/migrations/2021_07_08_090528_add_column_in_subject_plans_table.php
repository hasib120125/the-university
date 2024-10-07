<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInSubjectPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_plans', function (Blueprint $table) {
            $table->float('attendance_mark')->default(0)->nullable()->after('etc');
            $table->float('middle_mark')->default(0)->nullable()->after('etc');
            $table->float('ending_mark')->default(0)->nullable()->after('etc');
            $table->float('etc_mark')->default(0)->nullable()->after('etc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_plans', function (Blueprint $table) {
            $table->dropColumn('attendance_mark');
            $table->dropColumn('middle_mark');
            $table->dropColumn('ending_mark');
            $table->dropColumn('etc_mark');
        });
    }
}
