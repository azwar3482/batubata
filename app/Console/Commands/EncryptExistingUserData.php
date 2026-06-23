<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class EncryptExistingUserData extends Command
{
    protected $signature = 'users:encrypt-data {--dry-run : Hanya tampilkan, tanpa update database}';
    protected $description = 'Enkripsi data plaintext yang ada di kolom terenkripsi (phone, address, birth_date, blood_type, latitude, longitude)';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $fields = ['phone', 'address', 'birth_date', 'blood_type', 'latitude', 'longitude'];
        
        $this->info('Memeriksa data user yang perlu dienkripsi...');
        
        if ($dryRun) {
            $this->warn('Mode DRY RUN - tidak ada perubahan ke database');
        }

        $users = User::all();
        $totalUpdated = 0;

        foreach ($users as $user) {
            $updates = [];
            
            foreach ($fields as $field) {
                $value = $user->getOriginal($field);
                
                if (empty($value)) {
                    continue;
                }

                try {
                    decrypt($value);
                    $this->line("  [{$user->id}] {$field}: sudah terenkripsi");
                } catch (\Exception $e) {
                    $updates[$field] = encrypt($value);
                    $this->warn("  [{$user->id}] {$field}: plaintext '{$value}' -> akan dienkripsi");
                }
            }

            if (!empty($updates)) {
                if (!$dryRun) {
                    // Update langsung ke database tanpa melalui accessor
                    \DB::table('users')->where('id', $user->id)->update($updates);
                    $this->info("  [{$user->id}] BERHASIL diupdate");
                } else {
                    $this->info("  [{$user->id}] Akan diupdate: " . implode(', ', array_keys($updates)));
                }
                $totalUpdated++;
            }
        }

        $this->newLine();
        if ($totalUpdated > 0) {
            $this->info("Total user yang perlu diupdate: {$totalUpdated}");
            if (!$dryRun) {
                $this->info("Semua data berhasil dienkripsi!");
            }
        } else {
            $this->info("Semua data sudah terenkripsi dengan benar.");
        }

        return Command::SUCCESS;
    }
}
