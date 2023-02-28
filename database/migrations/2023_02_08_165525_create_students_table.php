<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('form_no');
            $table->string('roll')->unique();
            $table->string('added_by');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('fathersname');
            $table->string('mothersname');
            $table->string('mobile');
            $table->string('email');
            $table->string('photopath');
            $table->string('gender');
            $table->string('aadhar');
            $table->string('dob');
            $table->string('category');
            $table->string('timing');
            $table->string('course');
            $table->string('batch');
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
        Schema::dropIfExists('students');
    }
};
