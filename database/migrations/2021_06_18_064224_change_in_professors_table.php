<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->dropColumn('reg_no');
            $table->dropColumn('grade');
            $table->renameColumn('curriculum_id', 'department_id');
            $table->dropColumn('telephone');
            $table->dropColumn('status');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
            $table->dropColumn('professor_no');
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
            $table->string('email')->change();
            $table->dateTime('dob')->change();
            $table->string('address')->change();
            $table->string('reg_no');
            $table->integer('grade');
            $table->renameColumn('department_id', 'curriculum_id');
            $table->string('telephone');
            $table->string('status');
            $table->string('password');
            $table->rememberToken();
            $table->string('professor_no');
        });
    }
}
