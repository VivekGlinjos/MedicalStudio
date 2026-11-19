<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('college_course', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            $table->foreign('college_id')->references('college_id')->on('colleges')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::table('colleges', function (Blueprint $table) {
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
        });

        Schema::dropIfExists('college_course');
    }
};
