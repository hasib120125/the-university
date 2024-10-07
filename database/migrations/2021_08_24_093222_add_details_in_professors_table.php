<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsInProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->change();
            $table->dropColumn('subject_id');
            $table->unsignedBigInteger('custom_subject_id')->after('password')->nullable();
            $table->longText('details')->nullable()->after('password');
            $table->string('details_image')->nullable()->after('password');
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
            $table->dropColumn('custom_subject_id');
            $table->dropColumn('details');
            $table->dropColumn('details_image');
        });
    }
}
