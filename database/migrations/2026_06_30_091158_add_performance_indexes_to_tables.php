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
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('created_at');
            $table->index('is_active');
        });

        Schema::table('colleges', function (Blueprint $table) {
            $table->index('college_name');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index(['status', 'created_at'], 'payments_status_created_at_index');
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->index('email');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('colleges', function (Blueprint $table) {
            $table->dropIndex(['college_name']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex('payments_status_created_at_index');
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['created_at']);
        });
    }
};
