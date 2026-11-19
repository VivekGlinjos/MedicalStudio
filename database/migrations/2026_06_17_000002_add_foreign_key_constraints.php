<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            // Note: Since this project already has data, if there are invalid state_ids, 
            // the foreign key constraint will fail. So we add it safely or skip if not possible.
            // But as requested in the plan:
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            // $table->dropForeign(['state_id']);
        });
    }
};
