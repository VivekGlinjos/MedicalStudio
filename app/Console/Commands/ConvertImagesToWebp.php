<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\College;

class ConvertImagesToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:convert-webp {--disk=public}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert existing college images to WebP format to improve load time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image conversion to WebP...');
        
        $colleges = College::whereNotNull('college_image')->orWhereNotNull('college_banner')->get();
        $disk = Storage::disk($this->option('disk'));
        $count = 0;

        foreach ($colleges as $college) {
            // Convert College Image
            if ($college->college_image) {
                // If it doesn't contain the prefix, let's look in college-images/image/
                $path = $college->college_image;
                if (!str_contains($path, '/') && $disk->exists('college-images/image/' . $path)) {
                    $path = 'college-images/image/' . $path;
                }
                
                $newPath = $this->convertToWebp($disk, $path);
                if ($newPath && basename($newPath) !== basename($college->college_image)) {
                    // Save just the filename if it was just the filename before, or full path if it was full path
                    $college->college_image = str_contains($college->college_image, '/') ? $newPath : basename($newPath);
                    $college->save();
                    $count++;
                    $this->info("Converted image for college: {$college->college_name}");
                }
            }

            // Convert College Banner
            if ($college->college_banner) {
                $path = $college->college_banner;
                if (!str_contains($path, '/') && $disk->exists('college-images/image/' . $path)) {
                    $path = 'college-images/image/' . $path;
                }

                $newPath = $this->convertToWebp($disk, $path);
                if ($newPath && basename($newPath) !== basename($college->college_banner)) {
                    $college->college_banner = str_contains($college->college_banner, '/') ? $newPath : basename($newPath);
                    $college->save();
                    $count++;
                    $this->info("Converted banner for college: {$college->college_name}");
                }
            }
        }

        $this->info("Conversion completed! Converted {$count} images.");
    }

    private function convertToWebp($disk, $path)
    {
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'webp') {
            return $path; // Already webp
        }

        if (!$disk->exists($path)) {
            return $path; // File not found
        }

        $fullPath = $disk->path($path);
        $newRelativePath = preg_replace('/\.[^.]+$/', '.webp', $path);
        $newFullPath = $disk->path($newRelativePath);

        // Simple GD fallback
        $mime = mime_content_type($fullPath);
        $image = null;

        if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
            $image = @imagecreatefromjpeg($fullPath);
        } elseif ($mime == 'image/png') {
            $image = @imagecreatefrompng($fullPath);
            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
        }

        if ($image) {
            // Quality 80 for good compression
            if (imagewebp($image, $newFullPath, 80)) {
                imagedestroy($image);
                return $newRelativePath;
            }
        }

        return $path;
    }
}
