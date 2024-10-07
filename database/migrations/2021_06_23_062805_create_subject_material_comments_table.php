<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectMaterialCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_material_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_material_id');
            $table->unsignedBigInteger('student_id');
            $table->string('comment');
            $table->string('reply')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_material_comments');
    }
}
