<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJobAddressColumnInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('motive')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('job_address')->nullable()->change();
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
            $table->string('motive')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('job_address')->nullable()->change();
        });
    }
}
