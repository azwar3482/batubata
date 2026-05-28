<?php

namespace App\Services;

use App\Jobs\ProcessDocumentsJob;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProfileService
{
    public function updateProfile(User $user, array $validatedData, ?UploadedFile $photo, ?UploadedFile $cv)
    {
        if ($photo) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validatedData['photo'] = $photo->store('photos', 'public');
        }

        if ($cv) {
            if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
                Storage::disk('public')->delete($user->cv_path);
            }
            $validatedData['cv_path'] = $cv->store('cvs', 'public');
        }

        $user->fill(\Illuminate\Support\Arr::except($validatedData, ['career_histories']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (isset($validatedData['career_histories']) && is_array($validatedData['career_histories'])) {
            $user->careerHistories()->delete(); // Clear old entries
            foreach ($validatedData['career_histories'] as $history) {
                // Ensure is_current is boolean
                $history['is_current'] = isset($history['is_current']) && $history['is_current'] ? 1 : 0;
                $user->careerHistories()->create($history);
            }
        }

        return $user;
    }

    public function updateCvOnly(User $user, UploadedFile $cv)
    {
        if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
            Storage::disk('public')->delete($user->cv_path);
        }
        $path = $cv->store('cvs', 'public');

        $user->update(['cv_path' => $path]);

        return $user;
    }

    public function updatePhotoOnly(User $user, UploadedFile $photo)
    {
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }
        $path = $photo->store('photos', 'public');

        $user->update(['photo' => $path]);

        return $user;
    }

    /**
     * Upload multiple dokumen sekaligus dan masukkan ke antrean pemrosesan.
     * Menggunakan Bulk Insert untuk mencegah N+1 Writes.
     *
     * @param User $user
     * @param array $files Format: ['document_type' => UploadedFile, ...]
     * @return Collection Koleksi UserDocument yang baru dibuat
     */
    public function uploadDocuments(User $user, array $files): Collection
    {
        $documentsToInsert = [];
        $now = now();

        foreach ($files as $docType => $file) {
            if (!($file instanceof UploadedFile) || !$file->isValid()) {
                continue;
            }

            // Validasi tipe dokumen yang diizinkan
            if (!array_key_exists($docType, UserDocument::TYPES)) {
                continue;
            }

            // Simpan file ke storage
            $path = $file->store("documents/{$docType}", 'public');

            $documentsToInsert[] = [
                'user_id'       => $user->id,
                'document_type' => $docType,
                'original_name' => $file->getClientOriginalName(),
                'file_path'     => $path,
                'mime_type'     => $file->getMimeType(),
                'file_size'     => $file->getSize(),
                'status'        => UserDocument::STATUS_PENDING,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (empty($documentsToInsert)) {
            return collect();
        }

        // Bulk Insert semua dokumen sekaligus (Anti N+1 Writes)
        UserDocument::insert($documentsToInsert);

        // Ambil dokumen yang baru dibuat untuk mendapatkan ID-nya
        $newDocuments = UserDocument::where('user_id', $user->id)
            ->where('status', UserDocument::STATUS_PENDING)
            ->orderByDesc('created_at')
            ->take(count($documentsToInsert))
            ->get();

        // Dispatch SATU job tunggal untuk memproses semua dokumen baru (efisien)
        if ($newDocuments->isNotEmpty()) {
            ProcessDocumentsJob::dispatch($user->id, $newDocuments->pluck('id')->toArray());
        }

        return $newDocuments;
    }

    /**
     * Update koordinat lokasi GPS user.
     *
     * @param User $user
     * @param float $latitude
     * @param float $longitude
     * @param string|null $address
     */
    public function updateLocation(User $user, float $latitude, float $longitude, ?string $address = null): User
    {
        $user->update([
            'latitude'  => $latitude,
            'longitude' => $longitude,
            'address'   => $address ?? $user->address,
        ]);

        return $user;
    }
}

