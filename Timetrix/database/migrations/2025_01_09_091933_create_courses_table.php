<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_name');
            $table->string('course_code')->unique();
            $table->unsignedBigInteger('department_id'); // Column for the foreign key
            $table->integer('credits');
            $table->string('semester');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
