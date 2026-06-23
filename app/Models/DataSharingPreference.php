<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSharingPreference extends Model
{
    protected $table = 'data_sharing_preferences';

    protected $fillable = [
        'user_id',
        'share_profile',
        'share_contact',
        'share_education',
        'share_experience',
        'share_skills',
        'share_documents',
        'share_assessments',
        'share_tpa_scores',
        'share_blood_type',
        'share_location',
    ];

    protected $casts = [
        'share_profile' => 'boolean',
        'share_contact' => 'boolean',
        'share_education' => 'boolean',
        'share_experience' => 'boolean',
        'share_skills' => 'boolean',
        'share_documents' => 'boolean',
        'share_assessments' => 'boolean',
        'share_tpa_scores' => 'boolean',
        'share_blood_type' => 'boolean',
        'share_location' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getForUser(int $userId): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId],
            [
                'share_profile' => true,
                'share_contact' => true,
                'share_education' => true,
                'share_experience' => true,
                'share_skills' => true,
                'share_documents' => true,
                'share_assessments' => true,
                'share_tpa_scores' => false,
                'share_blood_type' => false,
                'share_location' => false,
            ]
        );
    }

    /**
     * Filter user data based on sharing preferences
     */
    public function filterUserData(User $user): array
    {
        $data = [];

        if ($this->share_profile) {
            $data['nama'] = $user->name;
            $data['foto'] = $user->documents->where('document_type', 'photo')->first()?->file_path;
            $data['bio'] = $user->bio;
            $data['jenis_kelamin'] = $user->gender;
        }

        if ($this->share_contact) {
            $data['email'] = $user->email;
            $data['telepon'] = $user->phone;
        }

        if ($this->share_education) {
            $data['jenjang_pendidikan'] = $user->education_level;
            $data['jurusan'] = $user->major;
            $data['tahun_lulus'] = $user->graduation_year;
            $data['institusi'] = $user->institution?->name;
        }

        if ($this->share_experience) {
            $data['pengalaman_tahun'] = $user->experience_years;
            $data['riwayat_kerja'] = $user->careerHistories->map(fn($h) => [
                'perusahaan' => $h->company_name,
                'posisi' => $h->position,
                'tanggal_mulai' => $h->start_date,
                'tanggal_selesai' => $h->end_date,
                'deskripsi' => $h->description,
            ]);
        }

        if ($this->share_skills) {
            $data['keahlian'] = $user->skills;
            $data['bahasa'] = $user->languages;
            $data['linkedin'] = $user->linkedin_url;
            $data['github'] = $user->github_url;
            $data['portfolio'] = $user->portfolio_url;
        }

        if ($this->share_documents) {
            $data['dokumen'] = $user->documents
                ->where('document_type', '!=', 'photo')
                ->map(fn($d) => [
                    'jenis' => $d->document_type,
                    'nama' => $d->original_name,
                    'url' => \Storage::url($d->file_path),
                ]);
        }

        if ($this->share_assessments) {
            $data['asesmen'] = $user->assessments->map(fn($a) => [
                'tanggal' => $a->assessment_date,
                'posisi' => $a->position?->name,
                'gap_percentage' => $a->total_gap_percentage,
            ]);
        }

        if ($this->share_tpa_scores) {
            $data['tpa'] = $user->tpaResults->map(fn($r) => [
                'tanggal' => $r->created_at,
                'total_score' => $r->total_score,
                'lulus' => $r->is_passed,
            ]);
        }

        if ($this->share_blood_type) {
            $data['golongan_darah'] = $user->blood_type;
        }

        if ($this->share_location) {
            $data['alamat'] = $user->address;
            $data['latitude'] = $user->latitude;
            $data['longitude'] = $user->longitude;
        }

        return $data;
    }
}
