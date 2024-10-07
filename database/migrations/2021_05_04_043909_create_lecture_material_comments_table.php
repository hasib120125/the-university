<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureMaterialCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_material_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lecture_material_id');
            $table->unsignedBigInteger('student_id');
            $table->string('comment');
            $table->string('reply')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecture_material_comments');
    }
}
