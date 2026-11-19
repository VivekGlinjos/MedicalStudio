<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\College;
use App\Models\SeatMatrix;

class SyncSeatMatrixData extends Command
{
    protected $signature = 'seat-matrix:sync-2025';
    protected $description = 'Clean old seat matrix data and re-sync from colleges table';

    public function handle()
    {
        $this->info('Cleaning old seat matrix records...');
        $deleted = SeatMatrix::truncate();
        $this->info('Old records deleted.');

        $colleges = College::where('total_seats', '>', 0)->get();
        $inserted = 0;

        foreach ($colleges as $college) {
            SeatMatrix::create([
                'college_id'  => $college->college_id,
                'course_id'   => 1, // MBBS
                'category'    => 'UR',
                'quota'       => 'AIQ',
                'total_seats' => $college->total_seats,
                'vacant_seats' => null,
            ]);
            $inserted++;
        }

        $this->info("Done! Inserted {$inserted} seat matrix records from real 2025 data.");
    }
}
