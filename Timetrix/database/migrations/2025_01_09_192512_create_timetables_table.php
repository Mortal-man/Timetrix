<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id('timetable_id');
            $table->unsignedBigInteger('course_id'); // Column for the foreign key
            $table->unsignedBigInteger('instructor_id'); // Column for the foreign key
            $table->unsignedBigInteger('classroom_id'); // Column for the foreign key
            $table->unsignedBigInteger('schedule_id'); // Column for the foreign key
            $table->string('semester');
            $table->enum('status', ['Active', 'Archived']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
