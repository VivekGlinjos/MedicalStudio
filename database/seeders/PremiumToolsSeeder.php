<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\College;
use App\Models\Course;
use App\Models\Cutoff;
use App\Models\SeatMatrix;

class PremiumToolsSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = College::all();
        $courses = Course::all();

        if ($colleges->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No colleges or courses found. Please run import:legacy first.');
            return;
        }

        $categories = ['UR', 'OBC', 'SC', 'ST', 'EWS'];
        $quotas = ['AIQ', 'State', 'Management'];

        $this->command->info('Generating Seat Matrices & Cutoffs using bulk inserts...');

        $seatMatricesData = [];
        $cutoffsData = [];

        foreach ($colleges as $college) {
            foreach ($courses as $course) {
                foreach ($categories as $category) {
                    foreach ($quotas as $quota) {
                        // Seat Matrix
                        $totalSeats = rand(5, 50);
                        $vacantSeats = rand(0, (int)($totalSeats * 0.3));

                        $seatMatricesData[] = [
                            'college_id' => $college->college_id,
                            'course_id' => $course->id,
                            'category' => $category,
                            'quota' => $quota,
                            'total_seats' => $totalSeats,
                            'vacant_seats' => $vacantSeats,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        // Cutoffs
                        $baseRank = rand(1000, 150000);
                        if ($category === 'SC' || $category === 'ST') {
                            $baseRank += rand(50000, 100000);
                        }
                        
                        $baseScore = max(100, 720 - ($baseRank / 250));

                        for ($round = 1; $round <= 3; $round++) {
                            // Ranks drop in subsequent rounds
                            $closingRank = $baseRank + ($round * rand(500, 2000));
                            $closingScore = max(100, $baseScore - ($round * rand(5, 15)));

                            $cutoffsData[] = [
                                'college_id' => $college->college_id,
                                'course_id' => $course->id,
                                'category' => $category,
                                'quota' => $quota,
                                'round' => $round,
                                'closing_rank' => $closingRank,
                                'closing_score' => $closingScore,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }
        }

        // Bulk Insert in chunks of 1000 to prevent memory exhaustion
        $this->command->info('Inserting ' . count($seatMatricesData) . ' Seat Matrices...');
        foreach (array_chunk($seatMatricesData, 1000) as $chunk) {
            SeatMatrix::insert($chunk);
        }

        $this->command->info('Inserting ' . count($cutoffsData) . ' Cutoffs...');
        foreach (array_chunk($cutoffsData, 1000) as $chunk) {
            Cutoff::insert($chunk);
        }
        
        $this->command->info('Premium Tools Data (Cutoffs & Seat Matrices) seeded successfully.');
    }
}
