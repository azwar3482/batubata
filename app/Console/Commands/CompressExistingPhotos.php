<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CompressExistingPhotos extends Command
{
    protected $signature = 'compress:existing-photos {--dry-run : Hanya tampilkan tanpa mengubah file}';
    protected $description = 'Kompres semua foto yang sudah di-upload di storage/app/public';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $totalSaved = 0;
        $count = 0;

        $this->info('=== Compress Existing Photos ===');
        $this->newLine();

        $directories = ['documents/photo', 'photos', 'documents/custom', 'documents/portofolio'];

        foreach ($directories as $dir) {
            $fullDir = storage_path('app/public/' . $dir);
            if (!is_dir($fullDir)) {
                $this->line("  [SKIP] {$dir} - direktori tidak ditemukan");
                continue;
            }

            $files = array_merge(
                glob($fullDir . '/*.jpg') ?: [],
                glob($fullDir . '/*.jpeg') ?: [],
                glob($fullDir . '/*.png') ?: [],
                glob($fullDir . '/*.webp') ?: []
            );

            foreach ($files as $filePath) {
                $filename = basename($filePath);
                $originalSize = filesize($filePath);
                $imageInfo = @getimagesize($filePath);

                if (!$imageInfo) {
                    continue;
                }

                try {
                    $origWidth = $imageInfo[0];
                    $origHeight = $imageInfo[1];
                    $needsResize = $origWidth > 1200 || $origHeight > 1200;

                    if (!$needsResize && $originalSize < 500 * 1024) {
                        // Still generate WebP if needed
                        if ($ext !== 'webp' && !$dryRun) {
                            $webpPath = pathinfo($filePath, PATHINFO_DIRNAME) . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                            if (!file_exists($webpPath)) {
                                $webpSource = match ($imageInfo[2]) {
                                    IMAGETYPE_JPEG => imagecreatefromjpeg($filePath),
                                    IMAGETYPE_PNG => imagecreatefrompng($filePath),
                                    default => null,
                                };
                                if ($webpSource) {
                                    if ($imageInfo[2] === IMAGETYPE_PNG) {
                                        imagealphablending($webpSource, false);
                                        imagesavealpha($webpSource, true);
                                    }
                                    ob_start();
                                    imagewebp($webpSource, null, 80);
                                    $webpData = ob_get_clean();
                                    imagedestroy($webpSource);
                                    file_put_contents($webpPath, $webpData);
                                    $this->line("  [WEBP] {$dir}/" . pathinfo($filename, PATHINFO_FILENAME) . ".webp generated ({$this->formatBytes(strlen($webpData))})");
                                }
                            }
                        }
                        $this->line("  [OK] {$dir}/{$filename} - sudah optimal");
                        continue;
                    }

                    $source = match ($imageInfo[2]) {
                        IMAGETYPE_JPEG => imagecreatefromjpeg($filePath),
                        IMAGETYPE_PNG => imagecreatefrompng($filePath),
                        IMAGETYPE_WEBP => imagecreatefromwebp($filePath),
                        default => null,
                    };

                    if (!$source) {
                        continue;
                    }

                    $newWidth = $origWidth;
                    $newHeight = $origHeight;

                    if ($needsResize) {
                        $ratio = min(1200 / $origWidth, 1200 / $origHeight);
                        $newWidth = (int)round($origWidth * $ratio);
                        $newHeight = (int)round($origHeight * $ratio);
                    }

                    $resized = imagecreatetruecolor($newWidth, $newHeight);

                    if ($imageInfo[2] === IMAGETYPE_PNG || $imageInfo[2] === IMAGETYPE_WEBP) {
                        imagealphablending($resized, false);
                        imagesavealpha($resized, true);
                    }

                    imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                    imagedestroy($source);

                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    ob_start();
                    match ($ext) {
                        'png' => imagepng($resized, null, 6),
                        'webp' => imagewebp($resized, null, 80),
                        default => imagejpeg($resized, null, 80),
                    };
                    $encoded = ob_get_clean();
                    imagedestroy($resized);

                    $newSize = strlen($encoded);
                    $saved = $originalSize - $newSize;
                    $percent = $originalSize > 0 ? round((1 - $newSize / $originalSize) * 100, 1) : 0;

                    if ($saved > 0) {
                        if (!$dryRun) {
                            file_put_contents($filePath, $encoded);
                            $this->info("  [DONE] {$dir}/{$filename}: {$this->formatBytes($originalSize)} -> {$this->formatBytes($newSize)} (hemat {$percent}%)");
                        } else {
                            $this->info("  [DRY] {$dir}/{$filename}: {$this->formatBytes($originalSize)} -> {$this->formatBytes($newSize)} (hemat {$percent}%)");
                        }
                        $totalSaved += $saved;
                        $count++;
                    } else {
                        $this->line("  [OK] {$dir}/{$filename} - sudah optimal");
                    }

                    // Generate WebP version
                    if ($ext !== 'webp' && !$dryRun) {
                        $webpPath = pathinfo($filePath, PATHINFO_DIRNAME) . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                        if (!file_exists($webpPath)) {
                            $webpSource = match ($imageInfo[2]) {
                                IMAGETYPE_JPEG => imagecreatefromjpeg($filePath),
                                IMAGETYPE_PNG => imagecreatefrompng($filePath),
                                default => null,
                            };
                            if ($webpSource) {
                                if ($imageInfo[2] === IMAGETYPE_PNG) {
                                    imagealphablending($webpSource, false);
                                    imagesavealpha($webpSource, true);
                                }
                                ob_start();
                                imagewebp($webpSource, null, 80);
                                $webpData = ob_get_clean();
                                imagedestroy($webpSource);
                                file_put_contents($webpPath, $webpData);
                                $this->line("  [WEBP] {$dir}/" . pathinfo($filename, PATHINFO_FILENAME) . ".webp generated ({$this->formatBytes(strlen($webpData))})");
                            }
                        }
                    }

                } catch (\Exception $e) {
                    $this->error("  [ERR] {$dir}/{$filename}: {$e->getMessage()}");
                }
            }
        }

        $this->newLine();
        $this->info("File yang diproses: {$count}");
        $this->info("Total ruang yang dihemat: {$this->formatBytes($totalSaved)}");

        return self::SUCCESS;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
