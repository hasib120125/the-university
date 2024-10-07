<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMenusSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('can_delete')->after('status')->default(true);
        });

        Schema::table('sub_menus', function (Blueprint $table) {
            $table->boolean('can_delete')->after('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('can_delete');
        });

        Schema::table('sub_menus', function (Blueprint $table) {
            $table->dropColumn('can_delete');
        });
    }
}
