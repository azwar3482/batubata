<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile(
            $request->user(), 
            $request->validated(), 
            $request->file('photo'), 
            $request->file('cv')
        );

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
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

    public function deleteDocument($id): RedirectResponse
    {
        $document = \App\Models\UserDocument::where('user_id', Auth::id())->findOrFail($id);
        
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
        }
        
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
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekstrak data dari ijazah: ' . $e->getMessage()
            ], 500);
        }
    }
}
