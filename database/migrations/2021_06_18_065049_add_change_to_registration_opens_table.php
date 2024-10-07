<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeToRegistrationOpensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registration_opens', function (Blueprint $table) {
            $table->integer('semester_id')->after('id');
            $table->dropColumn('year');
            $table->dropColumn('season');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_opens', function (Blueprint $table) {
            $table->dropColumn('semester_id');
            $table->string('year');
            $table->unsignedInteger('season')->comment('season value 1-4');
        });
    }
}
