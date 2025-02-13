<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            // Foreign keys
            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onDelete('cascade');

            $table->foreign('instructor_id')
                ->references('instructor_id')
                ->on('instructors')
                ->onDelete('cascade');

            $table->foreign('classroom_id')
                ->references('classroom_id')
                ->on('classrooms')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['course_id']);
            $table->dropForeign(['instructor_id']);
            $table->dropForeign(['classroom_id']);
        });
    }
};
