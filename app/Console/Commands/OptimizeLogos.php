<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeLogos extends Command
{
    protected $signature = 'optimize:logos {--dry-run : Hanya tampilkan tanpa mengubah file}';
    protected $description = 'Kompres semua file logo di public/ agar lebih ringan';

    public function handle(): int
    {
        $logos = config('compression.logos', []);
        $dryRun = $this->option('dry-run');
        $totalSaved = 0;

        $this->info('=== Logo Optimization ===');
        $this->newLine();

        foreach ($logos as $relativePath => $settings) {
            $fullPath = public_path($relativePath);

            if (!file_exists($fullPath)) {
                $this->warn("  [SKIP] {$relativePath} - file tidak ditemukan");
                continue;
            }

            $originalSize = filesize($fullPath);
            $maxWidth = $settings['max_width'] ?? 200;
            $quality = $settings['quality'] ?? 80;

            try {
                $imageInfo = @getimagesize($fullPath);
                if (!$imageInfo) {
                    $this->warn("  [SKIP] {$relativePath} - bukan gambar valid");
                    continue;
                }

                $origWidth = $imageInfo[0];

                if ($origWidth <= $maxWidth) {
                    $this->line("  [OK] {$relativePath} - sudah optimal ({$origWidth}px)");
                    continue;
                }

                $source = match ($imageInfo[2]) {
                    IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
                    IMAGETYPE_PNG => imagecreatefrompng($fullPath),
                    IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
                    default => null,
                };

                if (!$source) {
                    $this->warn("  [SKIP] {$relativePath} - format tidak didukung");
                    continue;
                }

                $origHeight = $imageInfo[1];
                $ratio = $maxWidth / $origWidth;
                $newWidth = $maxWidth;
                $newHeight = (int)round($origHeight * $ratio);

                $resized = imagecreatetruecolor($newWidth, $newHeight);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                imagedestroy($source);

                ob_start();
                imagepng($resized, null, 6);
                $encoded = ob_get_clean();
                imagedestroy($resized);

                $newSize = strlen($encoded);
                $saved = $originalSize - $newSize;
                $percent = $originalSize > 0 ? round((1 - $newSize / $originalSize) * 100, 1) : 0;

                if (!$dryRun) {
                    file_put_contents($fullPath, $encoded);
                    $this->info("  [DONE] {$relativePath}: {$this->formatBytes($originalSize)} -> {$this->formatBytes($newSize)} (hemat {$percent}%)");
                } else {
                    $this->info("  [DRY] {$relativePath}: {$this->formatBytes($originalSize)} -> {$this->formatBytes($newSize)} (hemat {$percent}%)");
                }

                $totalSaved += $saved;

            } catch (\Exception $e) {
                $this->error("  [ERR] {$relativePath}: {$e->getMessage()}");
            }
        }

        $this->newLine();
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
