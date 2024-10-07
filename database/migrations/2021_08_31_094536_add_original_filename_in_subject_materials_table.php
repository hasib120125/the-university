<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalFilenameInSubjectMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_materials', function (Blueprint $table) {
            $table->string('attachment1_original_filename')->nullable()->after('attachment1');
            $table->string('attachment2_original_filename')->nullable()->after('attachment2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_materials', function (Blueprint $table) {
            $table->dropColumn('attachment1_original_filename');
            $table->dropColumn('attachment2_original_filename');
        });
    }
}
