<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviewImageColumnInOfflineSeminersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_seminars', function (Blueprint $table) {
            $table->string('preview_image')->nullable()->after('content_ko');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_seminars', function (Blueprint $table) {
            $table->dropColumn('preview_image');
        });
    }
}
