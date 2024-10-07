<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('name_hangul');
            $table->string('name_chinese');
            $table->string('name_english');
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('dob');
            $table->string('photo')->nullable();
            $table->string('address');
            $table->string('reg_no');
            $table->integer('grade');
            $table->integer('curriculum_id');
            $table->string('telephone');
            $table->string('mobile');
            $table->string('status');
            $table->string('professor_no');
            $table->rememberToken();
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
        Schema::dropIfExists('professors');
    }
}
