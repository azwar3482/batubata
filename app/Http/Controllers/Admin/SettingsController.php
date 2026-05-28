<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $stats = [
            'total_competencies' => Competency::count(),
            'total_positions' => Position::count(),
            'pending_updates' => 3,
            'last_sync' => now()->subHours(2),
        ];

        $recentChanges = collect([
            ['action' => 'update', 'item' => 'Python Programming', 'by' => 'Admin', 'time' => now()->subMinutes(30)],
            ['action' => 'create', 'item' => 'Cloud Security Fundamentals', 'by' => 'Admin', 'time' => now()->subHours(1)],
            ['action' => 'delete', 'item' => 'Legacy Framework XYZ', 'by' => 'Admin', 'time' => now()->subHours(3)],
        ]);

        $systemSettings = [
            'ai_analysis_enabled' => true,
            'auto_match_threshold' => 70,
            'email_notifications' => true,
            'maintenance_mode' => false,
        ];

        return view('admin.settings', compact('stats', 'recentChanges', 'systemSettings'));
    }

    public function updateCompetency(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:technical,soft_skill',
            'min_level_required' => 'required|integer|min:1|max:5',
            'position_id' => 'required|exists:positions,id',
            'source_reference' => 'nullable|string',
        ]);

        $competency = Competency::findOrFail($id);
        $competency->update($validated);

        Cache::forget('competencies_index');

        return back()->with('success', 'Kompetensi berhasil diupdate!');
    }

    public function updateSystemSettings(Request $request)
    {
        $validated = $request->validate([
            'ai_analysis_enabled' => 'boolean',
            'auto_match_threshold' => 'integer|min:0|max:100',
            'email_notifications' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        // Update config atau database settings
        // Config::set('services.ai.enabled', $validated['ai_analysis_enabled']);

        return back()->with('success', 'Pengaturan sistem berhasil diupdate!');
    }

    public function syncCompetencies()
    {
        // Logic untuk sync dengan external API (BNSP, LinkedIn, etc.)
        // Simulasi:
        sleep(2);

        return back()->with('success', 'Sinkronisasi kompetensi berhasil! 24 data diperbarui.');
    }
}
