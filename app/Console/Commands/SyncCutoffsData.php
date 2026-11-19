<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncCutoffsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cutoffs:sync-2025';
    protected $description = 'Sync final closing ranks from colleges table to cutoffs table';

    public function handle()
    {
        $this->info('Starting cutoffs sync for 2025...');
        
        $colleges = \App\Models\College::all();
        $insertedCount = 0;

        foreach ($colleges as $college) {
            $categories = [
                'UR'  => $college->general_rank,
                'OBC' => $college->obc_rank,
                'SC'  => $college->sc_rank,
                'ST'  => $college->st_rank,
            ];

            foreach ($categories as $category => $rank) {
                if (!empty($rank)) {
                    \App\Models\Cutoff::updateOrCreate(
                        [
                            'college_id' => $college->college_id,
                            'course_id'  => 1, // MBBS
                            'category'   => $category,
                            'quota'      => 'AIQ',
                            'year'       => 2025,
                            'round'      => 'Final Round',
                        ],
                        [
                            'closing_rank' => (int) $rank,
                        ]
                    );
                    $insertedCount++;
                }
            }
        }

        $this->info("Successfully synced {$insertedCount} cutoff records for 2025!");
    }
}
