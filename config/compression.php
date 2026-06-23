<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Compression Settings
    |--------------------------------------------------------------------------
    |
    | Konfigurasi kompresi file untuk upload di profile dan dokumen.
    | Nilai ini digunakan oleh FileCompressionService.
    |
    */

    'image' => [
        // Dimensi maksimum gambar (akan di-resize maintain aspect ratio)
        'max_width' => env('COMPRESS_MAX_WIDTH', 1200),
        'max_height' => env('COMPRESS_MAX_HEIGHT', 1200),

        // Kualitas kompresi (0-100, semakin rendah semakin kecil)
        'quality' => env('COMPRESS_QUALITY', 80),

        // Target ukuran maksimum file foto profil (KB)
        'photo_max_size_kb' => env('COMPRESS_PHOTO_MAX_KB', 500),

        // Target ukuran maksimum dokumen gambar (KB)
        'document_max_size_kb' => env('COMPRESS_DOC_MAX_KB', 2048),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo Optimization
    |--------------------------------------------------------------------------
    |
    | Daftar file logo yang ada di public/ yang perlu dioptimasi.
    | Jalankan: php artisan optimize:logos
    |
    */
    'logos' => [
        'logo1.png' => ['max_width' => 300, 'quality' => 80],
        'logo.png' => ['max_width' => 200, 'quality' => 80],
        'logo_.png' => ['max_width' => 200, 'quality' => 80],
        'logo_v1.png' => ['max_width' => 200, 'quality' => 80],
        'logo - Copy.png' => ['max_width' => 200, 'quality' => 80],
        'images/logo_new.png' => ['max_width' => 200, 'quality' => 80],
    ],
];
