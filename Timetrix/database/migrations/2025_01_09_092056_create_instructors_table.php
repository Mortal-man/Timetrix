<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id('instructor_id');
            $table->unsignedBigInteger('user_id'); // Column for the foreign key
            $table->string('expertise');
            $table->json('availability');
            $table->unsignedBigInteger('department_id'); // Column for the foreign key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructors');
    }
}
