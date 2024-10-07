<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table)
        {
            $table->string('slug')->after('id');
            $table->renameColumn('title', 'title_en');
            $table->string('title_ko')->after('id');
            $table->renameColumn('content', 'content_en');
            $table->longText('content_ko')->after('id');
            $table->longText('summary_en')->after('id');
            $table->longText('summary_ko')->after('id');
            $table->string('cover')->after('thumbs');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
