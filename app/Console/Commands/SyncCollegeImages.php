<?php

namespace App\Console\Commands;

use App\Models\College;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncCollegeImages extends Command
{
    protected $signature = 'college:sync-images
                            {sqlfile : Absolute path to the old colleges.sql file}
                            {--dry-run : Preview changes without applying them}';

    protected $description = 'Import old colleges SQL, match by name, and copy image/banner filenames to the current colleges table';

    public function handle(): int
    {
        $sqlFile = $this->argument('sqlfile');
        $dryRun  = $this->option('dry-run');

        if (!file_exists($sqlFile)) {
            $this->error("File not found: {$sqlFile}");
            return self::FAILURE;
        }

        $this->info("SQL file: {$sqlFile}");
        if ($dryRun) {
            $this->warn('🔍 DRY RUN — no changes will be written');
        }
        $this->newLine();

        // ─── Step 1: Import via Native MySQL CLI ────────────────
        $this->info('Step 1: Importing old colleges via Native MySQL CLI…');

        // Drop temp table if exists
        DB::statement("DROP TABLE IF EXISTS `_old_colleges_tmp`");

        // Read the SQL file, replace table name, and write to a temporary file
        $sql = file_get_contents($sqlFile);
        $sql = str_replace('`colleges`', '`_old_colleges_tmp`', $sql);
        $sql = preg_replace('/ALTER TABLE.*?;/s', '', $sql); // Remove ALTER statements
        
        $tempSqlFile = storage_path('app/temp_import.sql');
        file_put_contents($tempSqlFile, $sql);

        // Execute via Native MySQL CLI
        $dbName = env('DB_DATABASE', 'medical_studio');
        $dbUser = env('DB_USERNAME', 'root');
        
        // Use XAMPP mysql binary directly to avoid path issues
        $mysqlCmd = "c:\\xampp\\mysql\\bin\\mysql.exe";
        if (!file_exists($mysqlCmd)) {
            $mysqlCmd = "mysql"; // Fallback to system path
        }
        
        $command = "{$mysqlCmd} -u {$dbUser} {$dbName} < \"{$tempSqlFile}\"";
        exec($command, $output, $returnVar);

        // Clean up temp file
        @unlink($tempSqlFile);

        if ($returnVar !== 0) {
            $this->error("Native MySQL import failed (Code: {$returnVar})");
            return self::FAILURE;
        }

        $oldCount = DB::table('_old_colleges_tmp')->count();
        $this->info("   Imported {$oldCount} colleges from old database");

        $oldWithImages = DB::table('_old_colleges_tmp')
            ->where('college_image', '!=', '')
            ->count();
        $this->info("   Of which {$oldWithImages} have images");
        $this->newLine();

        // ─── Step 2: Match by name and sync ──────────────────────
        $this->info('Step 2: Matching and syncing images…');

        if ($dryRun) {
            // Dry run: just show what would be updated
            $matches = DB::select("
                SELECT 
                    n.college_id,
                    n.college_name,
                    n.college_image AS current_image,
                    o.college_image AS old_image,
                    n.college_banner AS current_banner,
                    o.college_banner AS old_banner
                FROM colleges n
                INNER JOIN _old_colleges_tmp o 
                    ON LOWER(TRIM(n.college_name)) = LOWER(TRIM(o.college_name))
                WHERE o.college_image != '' OR o.college_banner != ''
            ");

            $this->info("   Would update " . count($matches) . " colleges");
        } else {
            // Real run: UPDATE via JOIN
            // We ALWAYS overwrite now based on user request.
            $updated = DB::update("
                UPDATE colleges n
                INNER JOIN _old_colleges_tmp o 
                    ON LOWER(TRIM(n.college_name)) = LOWER(TRIM(o.college_name))
                SET 
                    n.college_image = CASE 
                        WHEN o.college_image != '' THEN o.college_image 
                        ELSE n.college_image 
                    END,
                    n.college_banner = CASE 
                        WHEN o.college_banner != '' THEN o.college_banner 
                        ELSE n.college_banner 
                    END
                WHERE o.college_image != '' OR o.college_banner != ''
            ");

            $this->info("   ✅ Updated {$updated} colleges with images from old database");
        }

        // ─── Step 3: Report unmatched ────────────────────────────
        $this->newLine();
        $this->info('Step 3: Checking for unmatched colleges…');

        $unmatched = DB::select("
            SELECT o.college_id, o.college_name, o.college_image
            FROM _old_colleges_tmp o
            LEFT JOIN colleges n 
                ON LOWER(TRIM(n.college_name)) = LOWER(TRIM(o.college_name))
            WHERE n.college_id IS NULL
              AND (o.college_image != '' OR o.college_banner != '')
        ");

        if (count($unmatched) > 0) {
            $this->warn("   " . count($unmatched) . " old colleges had no name match:");
            $rows = array_map(fn($u) => [
                $u->college_id,
                mb_substr($u->college_name, 0, 60),
                $u->college_image ?: '—',
            ], $unmatched);
            $this->table(['Old ID', 'Name', 'Image'], $rows);
        } else {
            $this->info("   All old colleges matched! 🎉");
        }

        // ─── Cleanup ─────────────────────────────────────────────
        DB::statement("DROP TABLE IF EXISTS `_old_colleges_tmp`");

        $this->newLine();
        if ($dryRun) {
            $this->warn('🔍 DRY RUN complete. Run without --dry-run to apply.');
        } else {
            $this->info('✅ Sync complete! Run `php artisan college:verify-images` to verify.');
        }

        return self::SUCCESS;
    }
}
