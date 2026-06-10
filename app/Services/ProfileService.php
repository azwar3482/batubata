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
            $this->uploadDocument($user, $photo, 'photo');
        }

        if ($cv) {
            $this->uploadDocument($user, $cv, 'cv');
        }

        // Filter out photo and cv from validated data
        $userData = \Illuminate\Support\Arr::except($validatedData, ['career_histories', 'photo', 'cv']);

        // Handle array fields - save empty arrays as null
        foreach (['skills', 'languages', 'expected_jobs'] as $arrayField) {
            if (isset($userData[$arrayField]) && is_array($userData[$arrayField]) && empty(array_filter($userData[$arrayField], function($item) {
                return !empty($item) && (!is_array($item) || !empty(array_filter($item)));
            }))) {
                $userData[$arrayField] = null;
            }
        }

        $user->fill($userData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (isset($validatedData['career_histories']) && is_array($validatedData['career_histories'])) {
            $user->careerHistories()->delete();
            foreach ($validatedData['career_histories'] as $history) {
                // Skip empty histories
                if (empty($history['company_name']) && empty($history['position'])) {
                    continue;
                }
                $history['is_current'] = isset($history['is_current']) && $history['is_current'] ? 1 : 0;
                $user->careerHistories()->create($history);
            }
        }

        return $user;
    }

    protected function uploadDocument(User $user, UploadedFile $file, string $docType): void
    {
        $oldDocs = UserDocument::where('user_id', $user->id)
            ->where('document_type', $docType)
            ->get();

        foreach ($oldDocs as $oldDoc) {
            if (Storage::disk('public')->exists($oldDoc->file_path)) {
                Storage::disk('public')->delete($oldDoc->file_path);
            }
            $oldDoc->delete();
        }

        $path = $file->store("documents/{$docType}", 'public');

        UserDocument::create([
            'user_id'       => $user->id,
            'document_type' => $docType,
            'original_name' => $file->getClientOriginalName(),
            'file_path'     => $path,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'status'        => UserDocument::STATUS_COMPLETED,
        ]);
    }

    public function updateCvOnly(User $user, UploadedFile $cv)
    {
        $this->uploadDocument($user, $cv, 'cv');
        return $user;
    }

    public function updatePhotoOnly(User $user, UploadedFile $photo)
    {
        $this->uploadDocument($user, $photo, 'photo');
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

            // Hapus dokumen lama jika ada
            $oldDocs = UserDocument::where('user_id', $user->id)
                ->where('document_type', $docType)
                ->get();
                
            foreach ($oldDocs as $oldDoc) {
                if (Storage::disk('public')->exists($oldDoc->file_path)) {
                    Storage::disk('public')->delete($oldDoc->file_path);
                }
                $oldDoc->delete();
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

