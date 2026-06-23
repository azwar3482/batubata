<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileCompressionService
{
    protected int $maxWidth;
    protected int $maxHeight;
    protected int $quality;
    protected int $photoMaxSizeKB;

    public function __construct()
    {
        $this->maxWidth = config('compression.image.max_width', 1200);
        $this->maxHeight = config('compression.image.max_height', 1200);
        $this->quality = config('compression.image.quality', 80);
        $this->photoMaxSizeKB = config('compression.image.photo_max_size_kb', 500);
    }

    public function compressImage(UploadedFile $file): UploadedFile
    {
        $mimeType = $file->getMimeType();

        if (!str_starts_with($mimeType, 'image/')) {
            return $file;
        }

        try {
            $sourcePath = $file->getPathname();
            $imageInfo = @getimagesize($sourcePath);

            if (!$imageInfo) {
                return $file;
            }

            [$originalWidth, $originalHeight] = $imageInfo;
            $originalSize = $file->getSize();

            // Load source image based on type
            $source = match ($imageInfo[2]) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
                IMAGETYPE_PNG => imagecreatefrompng($sourcePath),
                IMAGETYPE_WEBP => imagecreatefromwebp($sourcePath),
                default => null,
            };

            if (!$source) {
                return $file;
            }

            // Calculate new dimensions (maintain aspect ratio)
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;

            if ($originalWidth > $this->maxWidth || $originalHeight > $this->maxHeight) {
                $ratioX = $this->maxWidth / $originalWidth;
                $ratioY = $this->maxHeight / $originalHeight;
                $ratio = min($ratioX, $ratioY);
                $newWidth = (int)round($originalWidth * $ratio);
                $newHeight = (int)round($originalHeight * $ratio);
            }

            // Create resized image
            $resized = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG/WebP
            if ($imageInfo[2] === IMAGETYPE_PNG || $imageInfo[2] === IMAGETYPE_WEBP) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            imagedestroy($source);

            // Determine output format
            $extension = strtolower($file->getClientOriginalExtension());
            $tempPath = tempnam(sys_get_temp_dir(), 'compressed_');

            // Encode with compression, progressively reduce quality if needed
            $currentQuality = $this->quality;

            do {
                $encoded = match ($extension) {
                    'png' => $this->encodePng($resized, $tempPath),
                    'webp' => $this->encodeWebp($resized, $tempPath, $currentQuality),
                    default => $this->encodeJpeg($resized, $tempPath, $currentQuality),
                };

                $compressedSize = strlen($encoded);

                if ($compressedSize > $this->photoMaxSizeKB * 1024 && $currentQuality > 30) {
                    $currentQuality -= 10;
                } else {
                    break;
                }
            } while (true);

            imagedestroy($resized);

            // Write final file
            $outputPath = $tempPath . '.' . $extension;
            file_put_contents($outputPath, $encoded);
            @unlink($tempPath);

            $reduction = $originalSize > 0 ? round((1 - $compressedSize / $originalSize) * 100, 1) : 0;

            Log::info("Image compressed: {$file->getClientOriginalName()}", [
                'original_size' => $this->formatBytes($originalSize),
                'compressed_size' => $this->formatBytes($compressedSize),
                'reduction' => $reduction . '%',
                'quality' => $currentQuality,
                'dimensions' => "{$newWidth}x{$newHeight}",
            ]);

            return new UploadedFile(
                $outputPath,
                $file->getClientOriginalName(),
                $file->getMimeType(),
                null,
                true
            );

        } catch (\Exception $e) {
            Log::warning('Image compression failed, using original', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);
            return $file;
        }
    }

    /**
     * Compress an existing file on disk (for logos and stored photos).
     */
    public function compressExistingFile(string $fullPath, ?int $maxWidth = null, ?int $quality = null): bool
    {
        $maxWidth = $maxWidth ?? $this->maxWidth;
        $quality = $quality ?? $this->quality;

        if (!file_exists($fullPath)) {
            return false;
        }

        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo) {
            return false;
        }

        try {
            $source = match ($imageInfo[2]) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
                IMAGETYPE_PNG => imagecreatefrompng($fullPath),
                IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
                default => null,
            };

            if (!$source) {
                return false;
            }

            $originalWidth = $imageInfo[0];
            $originalHeight = $imageInfo[1];

            $newWidth = $originalWidth;
            $newHeight = $originalHeight;

            if ($originalWidth > $maxWidth) {
                $ratio = $maxWidth / $originalWidth;
                $newWidth = $maxWidth;
                $newHeight = (int)round($originalHeight * $ratio);
            }

            $resized = imagecreatetruecolor($newWidth, $newHeight);

            if ($imageInfo[2] === IMAGETYPE_PNG || $imageInfo[2] === IMAGETYPE_WEBP) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            imagedestroy($source);

            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            ob_start();
            match ($extension) {
                'png' => imagepng($resized),
                'webp' => imagewebp($resized, null, $quality),
                default => imagejpeg($resized, null, $quality),
            };
            $encoded = ob_get_clean();

            imagedestroy($resized);

            file_put_contents($fullPath, $encoded);

            return true;
        } catch (\Exception $e) {
            Log::warning('Existing file compression failed', [
                'path' => $fullPath,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function getCompressionStats(UploadedFile $original, UploadedFile $compressed): array
    {
        return [
            'original_name' => $original->getClientOriginalName(),
            'original_size' => $original->getSize(),
            'original_size_human' => $this->formatBytes($original->getSize()),
            'compressed_size' => $compressed->getSize(),
            'compressed_size_human' => $this->formatBytes($compressed->getSize()),
            'reduction_bytes' => $original->getSize() - $compressed->getSize(),
            'reduction_percent' => $original->getSize() > 0
                ? round((1 - $compressed->getSize() / $original->getSize()) * 100, 1)
                : 0,
        ];
    }

    private function encodeJpeg($image, string $path, int $quality): string
    {
        ob_start();
        imagejpeg($image, null, $quality);
        return ob_get_clean();
    }

    private function encodePng($image, string $path): string
    {
        ob_start();
        imagepng($image, null, 6); // PNG compression level 6 (0-9)
        return ob_get_clean();
    }

    private function encodeWebp($image, string $path, int $quality): string
    {
        ob_start();
        imagewebp($image, null, $quality);
        return ob_get_clean();
    }

    /**
     * Generate a WebP version of an image file.
     * Returns the path to the WebP file, or null if generation fails.
     */
    public function generateWebP(string $sourcePath, ?string $targetDir = null): ?string
    {
        if (!file_exists($sourcePath)) {
            return null;
        }

        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo || $imageInfo[2] === IMAGETYPE_WEBP) {
            return null; // Already WebP or not an image
        }

        try {
            $source = match ($imageInfo[2]) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
                IMAGETYPE_PNG => imagecreatefrompng($sourcePath),
                default => null,
            };

            if (!$source) {
                return null;
            }

            // Preserve transparency for PNG
            if ($imageInfo[2] === IMAGETYPE_PNG) {
                imagealphablending($source, false);
                imagesavealpha($source, true);
            }

            $webpPath = ($targetDir ?? dirname($sourcePath)) . '/' . pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

            ob_start();
            imagewebp($source, null, $this->quality);
            $webpData = ob_get_clean();
            imagedestroy($source);

            file_put_contents($webpPath, $webpData);

            Log::info("WebP generated", [
                'source' => basename($sourcePath),
                'webp_size' => $this->formatBytes(strlen($webpData)),
            ]);

            return $webpPath;
        } catch (\Exception $e) {
            Log::warning('WebP generation failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get the WebP URL for a given image storage path.
     * Returns the WebP URL if it exists, otherwise the original URL.
     */
    public static function getWebpUrl(string $storagePath): string
    {
        $fullPath = storage_path('app/public/' . $storagePath);
        $webpPath = pathinfo($fullPath, PATHINFO_DIRNAME) . '/' . pathinfo($fullPath, PATHINFO_FILENAME) . '.webp';

        if (file_exists($webpPath)) {
            $webpRelative = str_replace(storage_path('app/public/'), '', $webpPath);
            return \Storage::url($webpRelative);
        }

        return \Storage::url($storagePath);
    }

    /**
     * Check if a WebP version exists for a given storage path.
     */
    public static function hasWebP(string $storagePath): bool
    {
        $fullPath = storage_path('app/public/' . $storagePath);
        $webpPath = pathinfo($fullPath, PATHINFO_DIRNAME) . '/' . pathinfo($fullPath, PATHINFO_FILENAME) . '.webp';
        return file_exists($webpPath);
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
