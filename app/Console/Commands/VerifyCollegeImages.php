<?php

namespace App\Console\Commands;

use App\Models\College;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class VerifyCollegeImages extends Command
{
    protected $signature = 'college:verify-images {--limit= : Limit the number of colleges to check}';
    protected $description = 'Verify all college images exist in storage and report missing files';

    public function handle(): int
    {
        $query = College::query();

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $colleges = $query->get();

        $stats = [
            'total'           => 0,
            'with_image_db'   => 0,
            'with_banner_db'  => 0,
            'image_found'     => 0,
            'banner_found'    => 0,
        ];

        $missingImages  = [];
        $missingBanners = [];

        $this->output->progressStart($colleges->count());

        foreach ($colleges as $college) {
            $stats['total']++;
            $this->output->progressAdvance();

            // Check image
            if ($college->college_image) {
                $stats['with_image_db']++;

                $found = $this->imageExists($college->college_image);
                if ($found) {
                    $stats['image_found']++;
                } else {
                    $missingImages[] = [
                        'ID'   => $college->college_id,
                        'Name' => mb_substr($college->college_name, 0, 40),
                        'File' => $college->college_image,
                    ];
                }
            }

            // Check banner
            if ($college->college_banner) {
                $stats['with_banner_db']++;

                $found = $this->imageExists($college->college_banner);
                if ($found) {
                    $stats['banner_found']++;
                } else {
                    $missingBanners[] = [
                        'ID'   => $college->college_id,
                        'Name' => mb_substr($college->college_name, 0, 40),
                        'File' => $college->college_banner,
                    ];
                }
            }
        }

        $this->output->progressFinish();
        $this->newLine();

        // Summary table
        $this->info('═══════════════════════════════════════');
        $this->info('         VERIFICATION SUMMARY          ');
        $this->info('═══════════════════════════════════════');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total colleges scanned',     $stats['total']],
                ['Colleges with image in DB',  $stats['with_image_db']],
                ['Colleges with banner in DB', $stats['with_banner_db']],
                ['Image files found on disk',  $stats['image_found']],
                ['Banner files found on disk', $stats['banner_found']],
                ['Missing images',             count($missingImages)],
                ['Missing banners',            count($missingBanners)],
            ]
        );

        if (!empty($missingImages)) {
            $this->newLine();
            $this->error('Missing Images:');
            $this->table(['ID', 'Name', 'File'], $missingImages);
        }

        if (!empty($missingBanners)) {
            $this->newLine();
            $this->error('Missing Banners:');
            $this->table(['ID', 'Name', 'File'], $missingBanners);
        }

        if (empty($missingImages) && empty($missingBanners)) {
            $this->newLine();
            $this->info('✅ All referenced images found on disk! Ready for production.');
        }

        return self::SUCCESS;
    }

    /**
     * Check whether a file exists using the same logic as the College model.
     */
    protected function imageExists(string $value): bool
    {
        // New-style path (contains a slash)
        if (str_contains($value, '/')) {
            return Storage::disk('public')->exists($value);
        }

        // Legacy bare filename
        return Storage::disk('public')->exists('college-images/image/' . $value);
    }
}
