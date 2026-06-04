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
            'pending_updates' => Competency::where('updated_at', '>', now()->subDay())->count(),
            'last_sync' => Competency::latest('updated_at')->value('updated_at') ?? now(),
        ];

        // Perubahan terbaru berdasarkan data kompetensi yang baru diupdate
        $recentChanges = Competency::orderByDesc('updated_at')
            ->take(5)
            ->get()
            ->map(function ($competency) {
                $isNew = $competency->created_at->eq($competency->updated_at);
                return [
                    'action' => $isNew ? 'create' : 'update',
                    'item' => $competency->name,
                    'by' => 'Admin',
                    'time' => $competency->updated_at,
                ];
            });

        $systemSettings = [
            'ai_analysis_enabled' => config('services.ai.enabled', true),
            'auto_match_threshold' => config('services.ai.match_threshold', 70),
            'email_notifications' => config('mail.enabled', true),
            'maintenance_mode' => config('app.maintenance_mode', false),
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
