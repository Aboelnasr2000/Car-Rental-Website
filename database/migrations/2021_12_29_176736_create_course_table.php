<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Teacher_id');
            $table->foreign('Teacher_id')->references('id')->on('users');
            $table->string('PLanguage');
            $table->foreign('PLanguage')->references('PLanguage')->on('p_languages');
            $table->string('Information');
            $table->float('Price');
            $table->string('Image');
            $table->string('City');
            $table->foreign('City')->references('City')->on('offices');
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
        Schema::dropIfExists('courses');
    }
}