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
        Schema::table('cutoffs', function (Blueprint $table) {
            $table->string('round')->default('Final Round')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutoffs', function (Blueprint $table) {
            $table->integer('round')->default(1)->change();
        });
    }
};
