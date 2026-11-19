<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportLegacyData extends Command
{
    protected $signature = 'import:legacy';
    protected $description = 'Import legacy SQL dump into current database';

    public function handle()
    {
        $file = 'C:\Users\Sahad\Downloads\medical_studio (1) (1).sql';
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return;
        }

        $sql = file_get_contents($file);

        // Fix MySQL escaping for SQLite
        $sql = str_replace("\\'", "''", $sql);
        $sql = str_replace('\\"', '"', $sql);
        $sql = str_replace('\\r\\n', "\n", $sql);
        
        // Find all INSERT INTO statements, ignoring the rest of the file
        // A standard MySQL dump insert ends with `);` at the end of a line.
        preg_match_all('/INSERT INTO `([^`]+)` \(([^)]+)\) VALUES\s*(.*?);[\r\n]/s', $sql, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $table = $match[1];
            $columnsRaw = $match[2];
            $valuesRaw = $match[3];

            $this->info("Processing table: $table");

            // Extract columns
            $columns = array_map(function($c) {
                return trim($c, '` ');
            }, explode(',', $columnsRaw));
            
            $tempTable = 'temp_' . $table;
            DB::statement("DROP TABLE IF EXISTS $tempTable");
            
            $createCols = [];
            foreach ($columns as $col) {
                $createCols[] = "`$col` TEXT";
            }
            $createSql = "CREATE TABLE $tempTable (" . implode(', ', $createCols) . ")";
            DB::statement($createSql);
            
            // Replace the table name in the original insert statement to target the temp table
            $insertSql = "INSERT INTO `$tempTable` (" . $columnsRaw . ") VALUES " . $valuesRaw . ";";
            
            try {
                DB::unprepared($insertSql);
                $this->info("Imported raw data into $tempTable");
            } catch (\Exception $e) {
                $this->error("Failed to insert into $tempTable: " . $e->getMessage());
                continue;
            }

            // Now map the data into the real tables
            $this->mapData($table, $tempTable);
            
            // Drop temp table
            DB::statement("DROP TABLE IF EXISTS $tempTable");
        }

        $this->info('Done!');
    }

    private function mapData($table, $tempTable)
    {
        $rows = DB::table($tempTable)->get();
        if ($rows->isEmpty()) return;

        $insertData = [];

        foreach ($rows as $row) {
            if ($table === 'states') {
                $insertData[] = [
                    'id' => $row->state_id,
                    'name' => $row->state_name,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ];
            } elseif ($table === 'courses') {
                $insertData[] = [
                    'id' => $row->course_id,
                    'name' => $row->course_name,
                    'level' => 'UG', // fallback
                    'short_note' => $row->short_note ?? null,
                    'description' => $row->course_description ?? null,
                    'admission_requirements' => $row->admission_requirements ?? null,
                    'duration' => null,
                    'image' => $row->course_image ?? null,
                    'banner' => $row->course_banner ?? null,
                    'seo_text' => $row->seo_text ?? null,
                    'slug' => \Illuminate\Support\Str::slug($row->course_name),
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ];
            } elseif ($table === 'colleges') {
                // Colleges schema perfectly matches the legacy dump because we created it that way!
                // But wait, it might already exist and conflict on ID.
                DB::table('colleges')->where('college_id', $row->college_id)->delete();
                $insertData[] = (array)$row;
            } elseif ($table === 'enquiry') {
                $insertData[] = [
                    'id' => $row->enquiry_id,
                    'name' => $row->enquiry_name,
                    'email' => $row->enquiry_email,
                    'phone' => $row->enquiry_phone,
                    'course_id' => $row->course_id,
                    'college_id' => $row->college_id,
                    'message' => $row->enquiry_message,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ];
            } elseif ($table === 'service_packages') {
                $insertData[] = [
                    'id' => $row->sp_id,
                    'name' => $row->sp_name,
                    'amount' => $row->sp_amount,
                    'description' => $row->sp_description,
                    'payment_button_link' => $row->btn_link,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ];
            } elseif ($table === 'videos') {
                $insertData[] = [
                    'id' => $row->video_id,
                    'video_name' => $row->video_name,
                    'thumbnail' => $row->thumbnail_image,
                    'video_link' => $row->video_link,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ];
            }
        }

        if (!empty($insertData)) {
            try {
                if ($table === 'states') {
                    DB::table('states')->insertOrIgnore($insertData);
                } elseif ($table === 'courses') {
                    DB::table('courses')->insertOrIgnore($insertData);
                } elseif ($table === 'colleges') {
                    DB::table('colleges')->insertOrIgnore($insertData);
                } elseif ($table === 'enquiry') {
                    DB::table('enquiries')->insertOrIgnore($insertData);
                } elseif ($table === 'service_packages') {
                    DB::table('service_packages')->insertOrIgnore($insertData);
                } elseif ($table === 'videos') {
                    DB::table('videos')->insertOrIgnore($insertData);
                }
                $this->info("Mapped " . count($insertData) . " rows for $table");
            } catch (\Exception $e) {
                $this->error("Failed to map data for $table: " . $e->getMessage());
            }
        }
    }
}
