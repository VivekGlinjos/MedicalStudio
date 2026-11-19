<?php

namespace App\Console\Commands;

use App\Models\College;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportColleges extends Command
{
    protected $signature = 'import:colleges {file : CSV file path}';
    protected $description = 'Import colleges data from CSV file';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return;
        }

        $this->info("Importing colleges from {$filePath}...");

        $handle = fopen($filePath, 'r');
        $headers = fgetcsv($handle); // Read headers

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $collegeName = trim($row[0] ?? '');
            
            // If the first column is empty, the name might be at the end (index 16 or 17)
            if (empty($collegeName)) {
                $collegeName = trim($row[16] ?? '');
                if (empty($collegeName)) {
                    $collegeName = trim(end($row));
                }
            }

            if (empty($collegeName)) continue; // Skip if still empty

            $typeStr = strtolower(trim($row[1] ?? ''));
            $stateName = trim($row[2] ?? '');
            if (empty($stateName)) continue; // State is required

            $city = trim($row[3] ?? '');
            $place = trim($row[4] ?? '');
            $course = trim($row[5] ?? 'MBBS');
            
            // Clean up the fees string which might have encoding issues (â‚¹ -> ₹)
            $fees = trim($row[6] ?? '');
            $fees = str_replace(['â‚¹', '?', '₹₹'], ['₹', '₹', '₹'], $fees);

            $genRank = (int)($row[7] ?? 0);
            $obcRank = (int)($row[8] ?? 0);
            $scRank = (int)($row[9] ?? 0);
            $stRank = (int)($row[10] ?? 0);
            $seats = (int)($row[13] ?? 0);

            // Dynamically build category_cutoffs from columns index 14 onwards
            $categoryCutoffs = [];
            for ($i = 14; $i < count($headers); $i++) {
                if (isset($headers[$i]) && trim($headers[$i]) !== '') {
                    $catName = strtoupper(trim($headers[$i]));
                    $catRank = (int)($row[$i] ?? 0);
                    if ($catRank > 0) {
                        $categoryCutoffs[$catName] = $catRank;
                    }
                }
            }
            // Also add base categories
            if ($genRank > 0) $categoryCutoffs['GEN'] = $genRank;
            if ($obcRank > 0) $categoryCutoffs['OBC'] = $obcRank;
            if ($scRank > 0) $categoryCutoffs['SC'] = $scRank;
            if ($stRank > 0) $categoryCutoffs['ST'] = $stRank;

            $type = match(true) {
                str_contains($typeStr, 'central') => 3,
                str_contains($typeStr, 'govt') || str_contains($typeStr, 'government') => 0,
                str_contains($typeStr, 'private') => 1,
                str_contains($typeStr, 'deemed') => 2,
                default => 0,
            };

            // Find or create state
            $state = State::firstOrCreate(
                ['name' => $stateName],
                ['code' => strtoupper(substr($stateName, 0, 2))]
            );

            College::updateOrCreate(
                ['slug' => Str::slug($collegeName)],
                [
                    'college_name' => $collegeName,
                    'state_id' => $state->id,
                    'college_type' => $type,
                    'city' => $city,
                    'place' => $place,
                    'state' => $stateName,
                    'courses' => $course,
                    'college_fees' => $fees,
                    'general_rank' => $genRank,
                    'obc_rank' => $obcRank,
                    'sc_rank' => $scRank,
                    'st_rank' => $stRank,
                    'category_cutoffs' => empty($categoryCutoffs) ? null : $categoryCutoffs,
                    'total_seats' => $seats,
                    'is_active' => 1
                ]
            );
            $count++;
        }
        fclose($handle);

        $this->info("Successfully imported/updated {$count} colleges.");
    }
}
