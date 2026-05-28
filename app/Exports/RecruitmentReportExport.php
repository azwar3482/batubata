<?php

namespace App\Exports;

use App\Models\JobListing;
use App\Models\UserJobApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class RecruitmentReportExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $userId = Auth::id();
        return JobListing::where('user_id', $userId)
            ->withCount('applications')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Lowongan',
            'Posisi',
            'Tipe Pekerjaan',
            'Lokasi',
            'Pengalaman Dibutuhkan',
            'Jumlah Pelamar',
            'Tanggal Dibuat',
            'Batas Akhir',
            'Status'
        ];
    }

    public function map($job): array
    {
        return [
            $job->id,
            $job->title,
            ucfirst($job->work_type),
            $job->location,
            $job->experience_required,
            $job->applications_count,
            $job->created_at ? $job->created_at->format('Y-m-d') : '-',
            $job->expires_date ? \Carbon\Carbon::parse($job->expires_date)->format('Y-m-d') : '-',
            $job->is_active ? 'Aktif' : 'Non-aktif',
        ];
    }
}
