<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class CollegeCutoffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding colleges and cutoff marks from client Excel data without duplicates...');
        Artisan::call('import:client-data', [], $this->command->getOutput());
        $this->command->info('CollegeCutoffsSeeder completed successfully.');
    }
}

