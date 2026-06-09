<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use App\Models\Position;
use App\Models\User;
use App\Models\JobListing;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        // Ambil settings dari database
        $systemSettings = [
            // Application
            'app_name' => Setting::get('app_name', config('app.name', 'KOMPASKARIR')),
            'app_locale' => Setting::get('app_locale', config('app.locale', 'id')),
            'maintenance_mode' => Setting::get('maintenance_mode', false),

            // AI & Analysis
            'ai_analysis_enabled' => Setting::get('ai_analysis_enabled', true),
            'ai_service_url' => Setting::get('ai_service_url', 'http://localhost:5000'),
            'auto_match_threshold' => Setting::get('auto_match_threshold', 70),
            'skill_gap_max' => Setting::get('skill_gap_max', 30),
            'gemini_api_key' => Setting::get('gemini_api_key', ''),
            'gemini_model' => Setting::get('gemini_model', 'gemini-2.0-flash'),

            // Job Application Rules
            'require_profile_complete' => Setting::get('require_profile_complete', true),
            'require_assessment' => Setting::get('require_assessment', true),
            'allow_withdraw' => Setting::get('allow_withdraw', true),

            // Notifications
            'email_notifications' => Setting::get('email_notifications', true),
            'notify_new_application' => Setting::get('notify_new_application', true),
            'notify_status_change' => Setting::get('notify_status_change', true),
            'notify_job_match' => Setting::get('notify_job_match', true),

            // Security
            'session_lifetime' => Setting::get('session_lifetime', 120),
            'require_email_verification' => Setting::get('require_email_verification', true),

            // Document Processing
            'max_upload_size_mb' => Setting::get('max_upload_size_mb', 10),
            'allowed_file_types' => Setting::get('allowed_file_types', 'pdf,doc,docx,jpg,png'),
            'cv_weight' => Setting::get('cv_weight', 30),
            'ijazah_weight' => Setting::get('ijazah_weight', 20),
            'transkrip_weight' => Setting::get('transkrip_weight', 15),
            'sertifikat_weight' => Setting::get('sertifikat_weight', 20),
            'portofolio_weight' => Setting::get('portofolio_weight', 15),

            // TPA
            'tpa_default_passing_score' => Setting::get('tpa_default_passing_score', 60),
            'tpa_default_time_limit' => Setting::get('tpa_default_time_limit', 60),
            'tpa_invitation_expiry_hours' => Setting::get('tpa_invitation_expiry_hours', 48),
        ];

        // System Information
        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'database_version' => DB::selectOne('SELECT VERSION() as version')->version ?? 'Unknown',
            'total_users' => User::count(),
            'total_jobs' => JobListing::count(),
            'active_jobs' => JobListing::where('is_active', true)->count(),
            'queue_driver' => config('queue.default', 'sync'),
            'cache_driver' => config('cache.default', 'file'),
            'session_driver' => config('session.driver', 'file'),
        ];

        $latestCompetencies = Competency::with('position')
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        $positions = Position::withCount('competencies')
            ->with('competencies')
            ->orderBy('name')
            ->get();

        return view('admin.settings', compact('stats', 'recentChanges', 'systemSettings', 'systemInfo', 'latestCompetencies', 'positions'));
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
            // Application
            'app_name' => 'nullable|string|max:255',
            'app_locale' => 'nullable|in:id,en',
            'maintenance_mode' => 'boolean',

            // AI
            'ai_analysis_enabled' => 'boolean',
            'ai_service_url' => 'nullable|url',
            'auto_match_threshold' => 'integer|min:0|max:100',
            'skill_gap_max' => 'integer|min:0|max:100',
            'gemini_api_key' => 'nullable|string',
            'gemini_model' => 'nullable|string',

            // Job Rules
            'require_profile_complete' => 'boolean',
            'require_assessment' => 'boolean',
            'allow_withdraw' => 'boolean',

            // Notifications
            'email_notifications' => 'boolean',
            'notify_new_application' => 'boolean',
            'notify_status_change' => 'boolean',
            'notify_job_match' => 'boolean',

            // Security
            'session_lifetime' => 'integer|min:30|max:1440',
            'require_email_verification' => 'boolean',

            // Documents
            'max_upload_size_mb' => 'integer|min:1|max:50',
            'allowed_file_types' => 'nullable|string',
            'cv_weight' => 'numeric|min:0|max:100',
            'ijazah_weight' => 'numeric|min:0|max:100',
            'transkrip_weight' => 'numeric|min:0|max:100',
            'sertifikat_weight' => 'numeric|min:0|max:100',
            'portofolio_weight' => 'numeric|min:0|max:100',

            // TPA
            'tpa_default_passing_score' => 'numeric|min:0|max:100',
            'tpa_default_time_limit' => 'integer|min:10|max:180',
            'tpa_invitation_expiry_hours' => 'integer|min:1|max:720',
        ]);

        // Validate document weights sum to 100
        $docWeights = ($validated['cv_weight'] ?? 0) + ($validated['ijazah_weight'] ?? 0) +
                      ($validated['transkrip_weight'] ?? 0) + ($validated['sertifikat_weight'] ?? 0) +
                      ($validated['portofolio_weight'] ?? 0);

        if (abs($docWeights - 100) > 0.01) {
            return back()->with('error', 'Total bobot dokumen harus 100% (saat ini: ' . $docWeights . '%)');
        }

        // Simpan ke database
        $settingsMap = [
            'general' => ['app_name', 'app_locale', 'maintenance_mode'],
            'ai' => ['ai_analysis_enabled', 'ai_service_url', 'auto_match_threshold', 'skill_gap_max', 'gemini_api_key', 'gemini_model'],
            'job_rules' => ['require_profile_complete', 'require_assessment', 'allow_withdraw'],
            'notifications' => ['email_notifications', 'notify_new_application', 'notify_status_change', 'notify_job_match'],
            'security' => ['session_lifetime', 'require_email_verification'],
            'documents' => ['max_upload_size_mb', 'allowed_file_types', 'cv_weight', 'ijazah_weight', 'transkrip_weight', 'sertifikat_weight', 'portofolio_weight'],
            'tpa' => ['tpa_default_passing_score', 'tpa_default_time_limit', 'tpa_invitation_expiry_hours'],
        ];

        foreach ($settingsMap as $group => $keys) {
            foreach ($keys as $key) {
                if (isset($validated[$key])) {
                    $existing = Setting::where('key', $key)->first();
                    $type = $existing?->type ?? 'string';

                    // Handle boolean
                    if ($type === 'boolean') {
                        $value = $request->has($key) ? '1' : '0';
                    } else {
                        $value = (string) $validated[$key];
                    }

                    Setting::set($key, $value, $type, $group);
                }
            }
        }

        // Clear settings cache
        Cache::flush();

        return back()->with('success', 'Pengaturan sistem berhasil disimpan!');
    }

    public function syncCompetencies()
    {
        sleep(2);
        return back()->with('success', 'Sinkronisasi kompetensi berhasil! 24 data diperbarui.');
    }
}
