<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your closure based console
| commands. Each closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-mail', function () {
    $this->info('Sedang mencoba mengirim email tes ke azwar@pei.ac.id...');

    try {
        Mail::raw('Selamat! Konfigurasi SMTP Mailtrap Anda sudah berhasil dihubungkan dengan project KOMPASKARIR.', function ($message) {
            $message->to('azwar@pei.ac.id')
                    ->subject('Tes Koneksi Email KOMPASKARIR');
        });
        
        $this->info('✅ BERHASIL! Silakan cek Inbox Mailtrap Anda.');
    } catch (\Exception $e) {
        $this->error('❌ GAGAL! Terjadi kesalahan: ' . $e->getMessage());
    }
})->purpose('Kirim email tes menggunakan konfigurasi SMTP Laravel');