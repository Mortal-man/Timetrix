<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('department_code');
            $table->dropForeign(['faculty_id']);
            $table->dropColumn('faculty_id');
            $table->dropForeign(['head_of_department']);
            $table->dropColumn('head_of_department');
        });
    }
};
