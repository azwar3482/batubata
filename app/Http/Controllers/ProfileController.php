<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UploadCvRequest;
use App\Http\Requests\UploadPhotoRequest;
use App\Http\Requests\DeleteProfileRequest;
use App\Services\ProfileService;
use App\Jobs\DeleteUserDataJob;

use App\Models\Position;
use App\Models\UserDocument;
use App\Models\Consent;
use App\Models\DataSharingPreference;
use App\Services\DocumentExtractionService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit(Request $request): View
    {
        $positions = Position::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'positions' => $positions
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $this->profileService->updateProfile(
                $request->user(), 
                $request->validated(), 
                $request->file('photo'), 
                $request->file('cv')
            );

            // Handle blood_type consent
            $bloodType = $request->input('blood_type');
            $bloodConsent = $request->boolean('blood_type_consent');
            $hasExistingConsent = Consent::hasConsent($request->user()->id, 'blood_type');

            if ($bloodType && $bloodConsent && !$hasExistingConsent) {
                // Revoke previous consent if exists (use DB to avoid Eloquent issues)
                \DB::table('consents')
                    ->where('user_id', $request->user()->id)
                    ->where('consent_type', 'blood_type')
                    ->where('granted', true)
                    ->whereNull('revoked_at')
                    ->update(['revoked_at' => now(), 'updated_at' => now()]);

                // Create new consent
                Consent::create([
                    'user_id' => $request->user()->id,
                    'consent_type' => 'blood_type',
                    'granted' => true,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'granted_at' => now(),
                ]);
            }

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui!'
                ]);
            }

            return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal update profil', ['error' => $e->getMessage(), 'user_id' => $request->user()->id]);
            
            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan profil. Silakan coba lagi.'
                ], 500);
            }

            return Redirect::route('profile.edit')->with('error', 'Gagal menyimpan profil. Silakan coba lagi.');
        }
    }

    public function uploadCv(UploadCvRequest $request): RedirectResponse
    {
        $this->profileService->updateCvOnly(
            $request->user(), 
            $request->file('cv')
        );

        return back()->with('success', 'CV berhasil diupload!');
    }

    public function uploadPhoto(UploadPhotoRequest $request): RedirectResponse
    {
        $this->profileService->updatePhotoOnly(
            $request->user(), 
            $request->file('photo')
        );

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function uploadDocuments(Request $request): RedirectResponse
    {
        $request->validate([
            'documents' => 'required|array',
            'documents.*' => 'required|file|max:2048|mimes:pdf',
        ]);

        $this->profileService->uploadDocuments(
            $request->user(),
            $request->file('documents')
        );

        return back()->with('success', 'Dokumen berhasil diunggah dan sedang diproses!');
    }

    public function uploadVerificationDocuments(Request $request): RedirectResponse
    {
        $request->validate([
            'nib_document' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'siup_document' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'npwp_document' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'ktp_director_document' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
        ]);

        $user = $request->user();
        if (!$user->isIndustry() || !$user->company) {
            return back()->with('error', 'Akses ditolak.');
        }

        $company = $user->company;
        $statuses = $company->document_statuses ?? [];

        if ($request->hasFile('nib_document')) {
            $company->nib_document = $request->file('nib_document')->store('verifications', 'public');
            $statuses['nib'] = ['status' => 'pending', 'reason' => null];
        }
        if ($request->hasFile('siup_document')) {
            $company->siup_document = $request->file('siup_document')->store('verifications', 'public');
            $statuses['siup'] = ['status' => 'pending', 'reason' => null];
        }
        if ($request->hasFile('npwp_document')) {
            $company->npwp_document = $request->file('npwp_document')->store('verifications', 'public');
            $statuses['npwp'] = ['status' => 'pending', 'reason' => null];
        }
        if ($request->hasFile('ktp_director_document')) {
            $company->ktp_director_document = $request->file('ktp_director_document')->store('verifications', 'public');
            $statuses['ktp_director'] = ['status' => 'pending', 'reason' => null];
        }

        $company->document_statuses = $statuses;
        if ($company->verification_status === 'unverified' || $company->verification_status === 'rejected') {
            $company->verification_status = 'pending';
        }
        
        $company->save();

        return back()->with('success', 'Dokumen verifikasi berhasil diunggah. Silakan tunggu konfirmasi dari admin.');
    }

    public function deleteDocument($id): RedirectResponse
    {
        $document = \App\Models\UserDocument::where('user_id', Auth::id())->findOrFail($id);
        
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
        }
        
        // Hapus skor dokumen terkait untuk mencegah matching score usang (ghost data)
        \App\Models\UserDocumentScore::where('document_id', $id)->delete();
        
        $document->delete();
        
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function updateLocation(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
        ]);

        $this->profileService->updateLocation(
            $request->user(),
            $validated['latitude'],
            $validated['longitude'],
            $validated['address'] ?? null
        );

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil diperbarui']);
    }

    public function destroy(DeleteProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Logout and clear session synchronously
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 2. Dispatch job to clean up files and delete the user asynchronously
        DeleteUserDataJob::dispatch($user);

        return Redirect::to('/');
    }

    public function updateMobileLayout(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'mobile_layout' => 'nullable|in:sidebar,bottombar',
            'sidebar_position' => 'nullable|in:left,right',
        ]);

        $updateData = [];
        if ($request->has('mobile_layout')) {
            $updateData['mobile_layout'] = $validated['mobile_layout'];
        }
        if ($request->has('sidebar_position')) {
            $updateData['sidebar_position'] = $validated['sidebar_position'];
        }

        $request->user()->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi tata letak berhasil diperbarui!',
            'data' => $updateData,
        ]);
    }

    public function uploadCustomDocument(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'file'  => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png,webp',
        ]);

        try {
            $doc = $this->profileService->uploadCustomDocument(
                $request->user(),
                $request->file('file'),
                $validated['label']
            );

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diunggah!',
                'document' => [
                    'id'    => $doc->id,
                    'label' => $doc->display_name,
                    'url'   => \Storage::url($doc->file_path),
                    'size'  => $doc->file_size_human,
                    'status'=> $doc->status_label,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah dokumen: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCustomDocument($id): \Illuminate\Http\JsonResponse
    {
        $document = \App\Models\UserDocument::where('user_id', \Auth::id())
            ->where('document_type', \App\Models\UserDocument::TYPE_CUSTOM)
            ->findOrFail($id);

        if (\Storage::disk('public')->exists($document->file_path)) {
            \Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus.',
        ]);
    }

    public function extractIjazahData(Request $request, DocumentExtractionService $extractionService)
    {
        try {
            $user = $request->user();
            $ijazahDoc = UserDocument::where('user_id', $user->id)
                ->where('document_type', UserDocument::TYPE_IJAZAH)
                ->where('status', UserDocument::STATUS_COMPLETED)
                ->latest()
                ->first();

            if (!$ijazahDoc) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen Ijazah belum diunggah atau belum selesai diproses.'
                ], 404);
            }

            // Extract text from the PDF
            $text = $extractionService->extractTextFromFile($ijazahDoc);
            
            // Call Python AI Service
            $pythonService = app(\App\Services\PythonAIService::class);
            $aiResult = $pythonService->analyzeSkillGap([
                'text' => $text,
                'document_type' => 'ijazah',
                'user_id' => auth()->id()
            ]);

            $extractedData = $aiResult['extracted_data'] ?? [];
            $level = $extractedData['education_level'] ?? '';
            $major = $extractedData['major'] ?? '';

            if (empty($level) && empty($major)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teks berhasil dibaca, namun sistem tidak menemukan kecocokan kata kunci untuk Tingkat Pendidikan atau Jurusan Anda.'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengekstrak data pendidikan dari dokumen Ijazah.',
                'data' => [
                    'education_level' => $level,
                    'major' => $major
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal ekstrak data ijazah', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekstrak data dari ijazah. Silakan coba lagi atau input manual.'
            ], 500);
        }
    }

    public function updateConsent(Request $request)
    {
        $request->validate([
            'consent_type' => 'required|string|in:blood_type,data_processing,data_sharing,cookies',
            'granted' => 'required|boolean',
        ]);

        $type = $request->input('consent_type');
        $granted = $request->input('granted');

        if ($granted) {
            Consent::grant(
                $request->user()->id,
                $type,
                $request->ip(),
                $request->userAgent()
            );
        } else {
            Consent::revoke($request->user()->id, $type);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $granted ? 'Persetujuan telah diberikan.' : 'Persetujuan telah dicabut.',
            ]);
        }

        return back()->with('success', $granted ? 'Persetujuan telah diberikan.' : 'Persetujuan telah dicabut.');
    }

    public function revokeConsent(Request $request)
    {
        $request->validate([
            'consent_type' => 'required|string|in:blood_type,data_processing,data_sharing,cookies',
        ]);

        $type = $request->input('consent_type');
        Consent::revoke($request->user()->id, $type);

        // If revoking blood_type consent, also clear the blood_type value
        if ($type === 'blood_type') {
            $request->user()->update(['blood_type' => null]);
        }

        return back()->with('success', 'Persetujuan telah dicabut dan data terkait telah dihapus.');
    }

    public function updateSharingPreferences(Request $request)
    {
        $user = $request->user();
        
        $sharingFields = [
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

        $data = ['user_id' => $user->id];
        foreach ($sharingFields as $field) {
            $data[$field] = $request->boolean($field);
        }

        DataSharingPreference::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Preferensi berbagi data berhasil diperbarui!',
            ]);
        }

        return back()->with('success', 'Preferensi berbagi data berhasil diperbarui!');
    }
}
