<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('reg_year')->comment('value 1-4')->nullable()->after('bible_exam');
            $table->unsignedInteger('reg_season')->nullable()->after('bible_exam');
            $table->unsignedInteger('active')->after('bible_exam')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('reg_year');
            $table->dropColumn('reg_season');
            $table->dropColumn('active');
        });
    }
}
