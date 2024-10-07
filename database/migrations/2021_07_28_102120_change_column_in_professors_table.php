<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('mobile');
            $table->string('password')->nullable()->after('mobile');
            $table->rememberToken()->after('mobile');
            $table->string('professor_no')->after('mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
            $table->dropColumn('professor_no');
        });
    }
}
