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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('level', ['UG', 'PG'])->default('UG');
            $table->text('short_note')->nullable();
            $table->longText('description')->nullable();
            $table->longText('admission_requirements')->nullable();
            $table->string('duration')->nullable();
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->text('seo_text')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
