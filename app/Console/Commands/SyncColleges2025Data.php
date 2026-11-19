<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\College;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class CollegesImport implements ToCollection, WithHeadingRow
{
    public $rows = [];
    public function collection(Collection $rows)
    {
        $this->rows = $rows;
    }
}

class SyncColleges2025Data extends Command
{
    protected $signature = 'colleges:sync-2025-data {--file= : Path to the Excel file} {--dry-run : Only log matches, do not write to DB}';
    protected $description = 'Sync college data from 2025 Excel sheet';

    public function handle()
    {
        $filePath = $this->option('file');
        $isDryRun = $this->option('dry-run');

        if (!$filePath || !file_exists(base_path($filePath))) {
            $this->error("File not found at: {$filePath}");
            return 1;
        }

        $this->info("Importing from: {$filePath}" . ($isDryRun ? " (DRY RUN)" : ""));

        // Use Excel::toCollection to get all sheets
        $sheets = Excel::toCollection(new class implements WithHeadingRow {}, $filePath);

        $matchedCount = 0;
        $unmatchedCount = 0;
        $unmatchedData = [];

        foreach ($sheets as $sheetName => $rows) {
            foreach ($rows as $index => $row) {
                // Try to find the college name column (it sluggifies headers)
                $collegeName = $row['college_name'] ?? $row['college'] ?? $row['name'] ?? null;
            if (!$collegeName) {
                continue;
            }

            $searchName = trim($collegeName);
            $searchNameClean = strtolower(preg_replace('/[^a-zA-Z0-9 ]/', '', $searchName));

            // Exact Match
            $match = College::where('college_name', $searchName)->first();

            // Fuzzy matches
            if (!$match) {
                $match = College::whereRaw('LOWER(REPLACE(college_name, " ", "")) LIKE ?', ['%' . str_replace(' ', '', $searchNameClean) . '%'])->first();
            }
            if (!$match) {
                $match = College::whereRaw('LOWER(college_name) LIKE ?', ['%' . strtolower(substr($searchName, 0, 15)) . '%'])->first();
            }

            if ($match) {
                $matchedCount++;
                $this->info("MATCHED: {$searchName} -> ID: {$match->college_id}");

                if (!$isDryRun) {
                    $updateData = [];

                    if (isset($row['type'])) $updateData['college_type'] = $this->mapType($row['type']);
                    if (isset($row['city'])) $updateData['city'] = $row['city'];
                    
                    // Fees and ranks
                    if (isset($row['fees_display'])) $updateData['college_fees'] = $row['fees_display'];
                    if (isset($row['total_seats'])) $updateData['total_seats'] = (int) $row['total_seats'];
                    if (isset($row['general_rank'])) $updateData['general_rank'] = (int) $row['general_rank'];
                    if (isset($row['obc_rank'])) $updateData['obc_rank'] = (int) $row['obc_rank'];
                    if (isset($row['sc_rank'])) $updateData['sc_rank'] = (int) $row['sc_rank'];
                    if (isset($row['st_rank'])) $updateData['st_rank'] = (int) $row['st_rank'];
                    
                    // New Info
                    if (isset($row['bed_capacity'])) $updateData['hospital_beds'] = (int) $row['bed_capacity'];
                    if (isset($row['college_website'])) $updateData['website_link'] = $row['college_website'];
                    
                    // Contacts (check common header variations)
                    if (isset($row['college_dean_email'])) $updateData['dean_email'] = $row['college_dean_email'];
                    if (isset($row['dean_email'])) $updateData['dean_email'] = $row['dean_email'];
                    
                    if (isset($row['contact_no'])) $updateData['dean_contact'] = $row['contact_no'];
                    if (isset($row['dean_contact_no'])) $updateData['dean_contact'] = $row['dean_contact_no'];
                    
                    if (isset($row['principle_email'])) $updateData['principal_email'] = $row['principle_email'];
                    if (isset($row['principal_email'])) $updateData['principal_email'] = $row['principal_email'];
                    
                    if (isset($row['principle_contact_no'])) $updateData['principal_contact'] = $row['principle_contact_no'];
                    if (isset($row['principal_contact_no'])) $updateData['principal_contact'] = $row['principal_contact_no'];
                    
                    if (isset($row['nodal_office_email'])) $updateData['nodal_email'] = $row['nodal_office_email'];
                    if (isset($row['nodal_email'])) $updateData['nodal_email'] = $row['nodal_email'];
                    
                    if (isset($row['nodal_contact_no'])) $updateData['nodal_contact'] = $row['nodal_contact_no'];
                    
                    $match->update($updateData);
                }
            } else {
                $unmatchedCount++;
                $this->warn("UNMATCHED: {$searchName}");
                $unmatchedData[] = implode(',', ['"' . $searchName . '"', '"' . ($row['state'] ?? '') . '"']);
            }
            } // End of inner foreach
        } // End of outer foreach

        $this->info("Completed. Matched: {$matchedCount}, Unmatched: {$unmatchedCount}");

        if ($unmatchedCount > 0) {
            Storage::put('unmatched_colleges.csv', "College Name,State\n" . implode("\n", $unmatchedData));
            $this->info("Unmatched colleges saved to storage/app/unmatched_colleges.csv");
        }

        return 0;
    }

    private function mapType($typeStr)
    {
        $t = strtolower(trim($typeStr));
        if (str_contains($t, 'gov') || str_contains($t, 'govt')) return 0;
        if (str_contains($t, 'priv')) return 1;
        if (str_contains($t, 'deem')) return 2;
        if (str_contains($t, 'cent')) return 3;
        return 0; // Default
    }
}
