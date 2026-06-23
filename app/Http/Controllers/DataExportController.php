<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Consent;
use App\Services\AuditLogService;

class DataExportController extends Controller
{
    public function export(Request $request)
    {
        $user = Auth::user();
        $format = $request->query('format', 'json');

        // Log export action (UU PDP compliance)
        AuditLogService::logDataExport($user->id, $format);

        $data = $this->collectAllUserData($user);

        if ($format === 'csv') {
            return $this->exportCsv($data, $user->name);
        }

        return $this->exportJson($data, $user->name);
    }

    private function collectAllUserData(User $user): array
    {
        $user->load([
            'careerHistories',
            'documents',
            'assessments.scores.competency',
            'tpaSessions',
            'tpaResults',
            'roadmaps',
            'jobApplications.jobListing',
            'courseProgress.course',
            'classEnrollments.classRoom.course',
        ]);

        return [
            'export_info' => [
                'platform' => 'KOMPASKARIR INDONESIA',
                'exported_at' => now()->toIso8601String(),
                'format_version' => '1.0',
                'legal_basis' => 'UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi - Pasal 16(1) Hak Portabilitas',
            ],
            'profil_pribadi' => [
                'id' => $user->id,
                'nama_lengkap' => $user->name,
                'email' => $user->email,
                'telepon' => $user->phone,
                'jenis_kelamin' => $user->gender,
                'tanggal_lahir' => $user->birth_date,
                'golongan_darah' => $user->blood_type,
                'alamat' => $user->address,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'bio' => $user->bio,
                'foto_profil' => $user->documents->where('document_type', 'photo')->first()?->file_path,
            ],
            'informasi_profesional' => [
                'jenjang_pendidikan' => $user->education_level,
                'jurusan' => $user->major,
                'tahun_lulus' => $user->graduation_year,
                'pengalaman_tahun' => $user->experience_years,
                'institusi' => $user->institution?->name,
                'keahlian' => $user->skills,
                'bahasa' => $user->languages,
                'linkedin_url' => $user->linkedin_url,
                'github_url' => $user->github_url,
                'portfolio_url' => $user->portfolio_url,
            ],
            'preferensi_pekerjaan' => [
                'posisi_target' => $user->target_position,
                'pekerjaan_diharapkan' => $user->expected_jobs,
                'preferensi_lainnya' => $user->job_preferences,
            ],
            'riwayat_pendidikan_formal' => [
                'jenjang' => $user->education_level,
                'jurusan' => $user->major,
                'tahun_lulus' => $user->graduation_year,
                'institusi' => $user->institution?->name,
            ],
            'riwayat_pengalaman_kerja' => $user->careerHistories->map(fn($h) => [
                'perusahaan' => $h->company_name,
                'posisi' => $h->position,
                'tanggal_mulai' => $h->start_date,
                'tanggal_selesai' => $h->end_date,
                'masih_bekerja' => $h->is_current,
                'deskripsi' => $h->description,
            ]),
            'dokumen' => $user->documents->map(fn($d) => [
                'jenis' => $d->document_type,
                'label' => $d->display_name ?? $d->label,
                'nama_file' => $d->original_name,
                'ukuran' => $d->file_size_human ?? $d->file_size,
                'status' => $d->status,
                'tanggal_unggah' => $d->created_at,
            ]),
            'asesmen_kompetensi' => $user->assessments->map(fn($a) => [
                'tanggal_asesmen' => $a->assessment_date,
                'posisi' => $a->position?->name,
                'total_gap_percentage' => $a->total_gap_percentage,
                'skor_detail' => $a->scores->map(fn($s) => [
                    'kompetensi' => $s->competency?->name,
                    'level_self_assessed' => $s->self_assessed_level,
                    'level_minimum' => $s->competency?->min_level_required,
                ]),
            ]),
            'hasil_tpa' => $user->tpaResults->map(fn($r) => [
                'tanggal_tes' => $r->created_at,
                'skor_verbal' => $r->verbal_score,
                'skor_numerik' => $r->numerik_score,
                'skor_logika' => $r->logika_score,
                'skor_spasial' => $r->spasial_score,
                'skor_total' => $r->total_score,
                'skor_bappenas' => $r->bappenas_score,
                'lulus' => $r->is_passed,
            ]),
            'career_roadmap' => $user->roadmaps->map(fn($r) => [
                'kompetensi' => $r->competency_name ?? $r->name,
                'level_saat_ini' => $r->current_level,
                'level_target' => $r->target_level,
                'rekomendasi' => $r->recommendations,
                'status' => $r->status,
            ]),
            'riwayat_lamaran' => $user->jobApplications->map(fn($a) => [
                'lowongan' => $a->jobListing?->title,
                'perusahaan' => $a->jobListing?->company?->name ?? $a->jobListing?->company_name,
                'tanggal_lamar' => $a->created_at,
                'status' => $a->status,
                'matching_score' => $a->matching_percentage,
            ]),
            'riwayat_kursus' => $user->courseProgress->map(fn($p) => [
                'judul_kursus' => $p->course?->title,
                'status' => $p->status,
                'progres_persen' => $p->progress_percentage,
                'tanggal_mulai' => $p->started_at,
                'tanggal_selesai' => $p->completed_at,
            ]),
            'riwayat_kelas' => $user->classEnrollments->map(fn($e) => [
                'nama_kelas' => $e->classRoom?->name,
                'nama_kursus' => $e->classRoom?->course?->title,
                'status' => $e->status,
                'tanggal_daftar' => $e->created_at,
            ]),
            'log_persetujuan' => Consent::where('user_id', $user->id)->get()->map(fn($c) => [
                'jenis_persetujuan' => $c->consent_type,
                'deskripsi' => Consent::TYPES()[$c->consent_type] ?? $c->consent_type,
                'disetujui' => $c->granted,
                'tanggal_disetujui' => $c->granted_at,
                'tanggal_dicabut' => $c->revoked_at,
                'versi' => $c->consent_version,
            ]),
            'informasi_akun' => [
                'tanggal_daftar' => $user->created_at,
                'terakhir_diperbarui' => $user->updated_at,
                'email_terverifikasi' => $user->email_verified_at ? true : false,
                'metode_daftar' => $user->provider ?? 'email',
                'peran' => $user->role,
            ],
        ];
    }

    private function exportJson(array $data, string $name)
    {
        $filename = 'KOMPASKARIR_DataPribadi_' . str_replace(' ', '_', $name) . '_' . now()->format('Y-m-d') . '.json';

        return response(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function exportCsv(array $data, string $name)
    {
        $filename = 'KOMPASKARIR_DataPribadi_' . str_replace(' ', '_', $name) . '_' . now()->format('Y-m-d') . '.csv';

        $handle = fopen('php://temp', 'r+');

        // Flatten the data for CSV
        fputcsv($handle, ['Kategori', 'Field', 'Nilai']);

        foreach ($data as $category => $items) {
            if ($category === 'export_info') {
                foreach ($items as $key => $value) {
                    fputcsv($handle, [$category, $key, $value]);
                }
                continue;
            }

            if (is_array($items) && !empty($items) && isset($items[0]) && is_array($items[0])) {
                // Array of objects
                foreach ($items as $index => $item) {
                    foreach ($item as $key => $value) {
                        if (is_array($value)) $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                        fputcsv($handle, [$category . '[' . ($index + 1) . ']', $key, $value]);
                    }
                }
            } elseif (is_array($items)) {
                // Simple key-value
                foreach ($items as $key => $value) {
                    if (is_array($value)) $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                    fputcsv($handle, [$category, $key, $value]);
                }
            }
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
