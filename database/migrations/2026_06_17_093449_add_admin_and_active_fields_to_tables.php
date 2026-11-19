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
            if (!Schema::hasColumn('users', 'is_admin')) $table->boolean('is_admin')->default(false)->after('password');
            if (!Schema::hasColumn('users', 'is_active')) $table->boolean('is_active')->default(true)->after('is_paid');
        });

        $tables = [
            'colleges', 'courses', 'states', 'service_packages', 
            'videos', 'college_galleries', 'blog_posts'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'is_active']);
        });

        $tables = [
            'colleges', 'courses', 'states', 'service_packages', 
            'videos', 'college_galleries', 'blog_posts'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};
