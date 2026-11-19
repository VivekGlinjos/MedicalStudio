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
        Schema::create('cutoffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained('colleges', 'college_id')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses', 'id')->onDelete('cascade');
            $table->string('category')->default('UR'); // UR, OBC, SC, ST, EWS, NRI
            $table->string('quota')->default('AIQ'); // AIQ, State, Management
            $table->integer('round')->default(1);
            $table->integer('year')->default(date('Y'));
            $table->integer('closing_rank');
            $table->integer('closing_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutoffs');
    }
};
