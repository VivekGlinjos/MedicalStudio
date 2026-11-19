<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add college_type = 3 (Central Govt) and reclassify known central institutions.
     */
    public function up(): void
    {
        // Update the comment on college_type (informational only for MySQL; SQLite ignores)
        // college_type: 0=Govt, 1=Private, 2=Deemed, 3=Central

        // Reclassify known central universities from Govt (0) to Central (3)
        $centralKeywords = [
            'AIIMS',
            'JIPMER',
            'PGIMER',
            'NIMHANS',
            'BHU',          // Banaras Hindu University
            'AMU',          // Aligarh Muslim University
            'Lady Hardinge',
            'LHMC',
            'Safdarjung',
            'VMMC',         // Vardhman Mahavir Medical College
            'ABVIMS',       // Atal Bihari Vajpayee Institute
            'Maulana Azad Medical College',
            'MAMC',
            'University College of Medical Sciences', // UCMS Delhi
        ];

        foreach ($centralKeywords as $keyword) {
            DB::table('colleges')
                ->where('college_name', 'like', "%{$keyword}%")
                ->where('college_type', 0) // Only reclassify if currently Govt
                ->update(['college_type' => 3]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert Central (3) back to Govt (0)
        DB::table('colleges')
            ->where('college_type', 3)
            ->update(['college_type' => 0]);
    }
};
