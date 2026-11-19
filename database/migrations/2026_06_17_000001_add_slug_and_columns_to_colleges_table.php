<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('college_name');
            $table->string('city')->nullable()->after('slug');
            $table->string('state')->nullable()->after('city');
            $table->integer('total_seats')->nullable()->after('year_of_inspection');
            $table->string('college_fees')->nullable()->after('total_seats');
            $table->integer('general_rank')->nullable();
            $table->integer('obc_rank')->nullable();
            $table->integer('sc_rank')->nullable();
            $table->integer('st_rank')->nullable();

            $table->index('slug');
            $table->index('state_id');
            $table->index('college_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['state_id']);
            $table->dropIndex(['college_type']);
            $table->dropIndex(['is_active']);
            
            $table->dropColumn([
                'slug', 'city', 'state', 'total_seats', 'college_fees', 
                'general_rank', 'obc_rank', 'sc_rank', 'st_rank'
            ]);
        });
    }
};
