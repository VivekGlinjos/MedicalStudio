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
        Schema::table('colleges', function (Blueprint $table) {
            if (!Schema::hasColumn('colleges', 'management_fee')) {
                $table->string('management_fee')->nullable()->after('college_fees');
            }
            if (!Schema::hasColumn('colleges', 'nri_fee')) {
                $table->string('nri_fee')->nullable()->after('management_fee');
            }
        });

        Schema::table('cutoffs', function (Blueprint $table) {
            // Add composite performance index if not exists
            $table->index(['college_id', 'year', 'quota', 'category'], 'cutoffs_composite_lookup_idx');
            $table->index(['year', 'quota', 'category', 'closing_rank'], 'cutoffs_filter_rank_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropColumn(['management_fee', 'nri_fee']);
        });

        Schema::table('cutoffs', function (Blueprint $table) {
            $table->dropIndex('cutoffs_composite_lookup_idx');
            $table->dropIndex('cutoffs_filter_rank_idx');
        });
    }
};

