<?php

namespace App\Services;

use App\Models\UserAssessment;
use App\Models\CareerRoadmap;
use Illuminate\Support\Facades\DB;

class RoadmapService
{
    public function generateRoadmap(UserAssessment $assessment)
    {
        // Hapus roadmap lama jika ada untuk posisi ini agar tidak duplikat
        CareerRoadmap::where('user_id', $assessment->user_id)
            ->where('position_id', $assessment->position_id)
            ->delete();

        $scores = $assessment->scores()->with('competency')->orderByDesc('gap_percentage')->get();
        
        $highPrioritySkills = $scores->where('priority', 'high')->take(2);
        $mediumPrioritySkills = $scores->where('priority', 'medium')->take(2);
        
        $roadmaps = [];

        // Bulan 1: Fokus Skill High Priority #1
        if ($highPrioritySkills->isNotEmpty()) {
            $skill = $highPrioritySkills[0];
            $roadmaps[] = [
                'month_number' => 1,
                'title' => "Fundamental {$skill->competency->name}",
                'desc' => "Pelajari dasar-dasar {$skill->competency->name} melalui kursus online dan dokumentasi resmi."
            ];
        }

        // Bulan 2: Fokus Skill High Priority #2 atau Lanjutan #1
        if ($highPrioritySkills->count() > 1) {
            $skill = $highPrioritySkills[1];
            $roadmaps[] = [
                'month_number' => 2,
                'title' => "Pendalaman {$skill->competency->name}",
                'desc' => "Lanjutkan pembelajaran {$skill->competency->name} dan kerjakan latihan studi kasus sederhana."
            ];
        } else {
            $roadmaps[] = [
                'month_number' => 2,
                'title' => "Proyek Mini {$highPrioritySkills[0]->competency->name}",
                'desc' => "Terapkan skill {$highPrioritySkills[0]->competency->name} dalam sebuah proyek mini portofolio."
            ];
        }

        // Bulan 3: Skill Medium Priority #1
        if ($mediumPrioritySkills->isNotEmpty()) {
            $skill = $mediumPrioritySkills[0];
            $roadmaps[] = [
                'month_number' => 3,
                'title' => "Penguasaan {$skill->competency->name}",
                'desc' => "Mulai pelajari {$skill->competency->name} untuk melengkapi kompetensi teknis Anda."
            ];
        } else {
             $roadmaps[] = [
                'month_number' => 3,
                'title' => "Sertifikasi Kompetensi",
                'desc' => "Ikuti ujian sertifikasi atau selesaikan kursus lanjutan untuk validasi skill."
            ];
        }

        // Bulan 4: Skill Medium Priority #2 atau Soft Skill
        $roadmaps[] = [
            'month_number' => 4,
            'title' => "Pengembangan Soft Skill & Kolaborasi",
            'desc' => "Fokus pada komunikasi, teamwork, dan bergabung dengan komunitas profesional."
        ];

        // Bulan 5: Portofolio Lengkap
        $roadmaps[] = [
            'month_number' => 5,
            'title' => "Penyusunan Portofolio Profesional",
            'desc' => "Kumpulkan semua hasil proyek, buat dokumentasi GitHub/Behance, dan perbarui CV/LinkedIn."
        ];

        // Bulan 6: Simulasi Interview & Lamar Kerja
        $roadmaps[] = [
            'month_number' => 6,
            'title' => "Persiapan Karir & Interview",
            'desc' => "Latihan interview teknis, mock test, dan mulai melamar ke perusahaan target."
        ];

        // Simpan ke Database
        foreach ($roadmaps as $item) {
            CareerRoadmap::create([
                'user_id' => $assessment->user_id,
                'position_id' => $assessment->position_id,
                'month_number' => $item['month_number'],
                'milestone_title' => $item['title'],
                'milestone_description' => $item['desc'],
                'is_completed' => false
            ]);
        }

        return true;
    }
}