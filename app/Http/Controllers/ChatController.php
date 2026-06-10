<?php

namespace App\Http\Controllers;

use App\Services\ChatAgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatAgentService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Kirim pesan ke chat agent
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $message = $this->sanitizeInput($request->input('message'));
        $sessionId = $request->input('session_id');

        // Validasi session_id format
        if ($sessionId && !preg_match('/^chat_\d+_\d+$/', $sessionId)) {
            $sessionId = null;
        }

        // Cek apakah pesan kosong setelah sanitasi
        if (empty(trim($message))) {
            return response()->json([
                'success' => false,
                'error' => 'Pesan tidak boleh kosong.',
            ], 422);
        }

        $response = $this->chatService->chat($user, $message, $sessionId);

        if (!$response['success']) {
            return response()->json([
                'success' => false,
                'error' => $response['error'],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'text' => $response['text'],
            'deep_links' => $response['deep_links'],
            'suggestions' => $response['suggestions'],
            'session_id' => $response['session_id'],
        ]);
    }

    /**
     * Ambil chat history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $sessionId = $request->input('session_id');

        $messages = $this->chatService->getChatHistory($user->id, $sessionId);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Ambil daftar session
     */
    public function sessions()
    {
        $user = Auth::user();
        $sessions = $this->chatService->getChatSessions($user->id);

        return response()->json([
            'success' => true,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Hapus chat history
     */
    public function clearHistory(Request $request)
    {
        $user = Auth::user();
        $sessionId = $request->input('session_id');

        $this->chatService->clearHistory($user->id, $sessionId);

        return response()->json([
            'success' => true,
            'message' => 'Chat history berhasil dihapus.',
        ]);
    }

    /**
     * Ambil suggestions default
     */
    public function suggestions()
    {
        $user = Auth::user();

        $suggestions = match ($user->role) {
            'job_seeker' => [
                'Bagaimana cara melamar kerja?',
                'Apa itu Tes TPA?',
                'Bagaimana cara meningkatkan skill?',
                'Bagaimana cara upload CV?',
                'Bagaimana cara melihat hasil assessment?',
            ],
            'industry' => [
                'Bagaimana cara posting lowongan?',
                'Bagaimana cara mengundang kandidat ke TPA?',
                'Bagaimana cara mengelola tim?',
                'Apa itu document weight?',
                'Bagaimana cara melihat laporan?',
            ],
            'education' => [
                'Bagaimana cara membuat program?',
                'Bagaimana cara mengajukan kolaborasi?',
                'Bagaimana cara mengelola kursus?',
                'Bagaimana cara melihat analytics?',
            ],
            'admin' => [
                'Bagaimana cara mengelola user?',
                'Bagaimana cara menambah kompetensi?',
                'Bagaimana cara cek AI workflow?',
                'Bagaimana cara mengelola TPA?',
            ],
            default => ['Apa itu KOMPASKARIR?'],
        };

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * Cek status API
     */
    public function status()
    {
        $configured = app(\App\Services\GeminiService::class)->isConfigured();

        return response()->json([
            'success' => true,
            'configured' => $configured,
            'message' => $configured
                ? 'Gemini API sudah dikonfigurasi.'
                : 'Gemini API belum dikonfigurasi. Tambahkan GEMINI_API_KEY di .env',
        ]);
    }

    /**
     * Sanitasi input user untuk mencegah injection dan abuse
     */
    protected function sanitizeInput(string $input): string
    {
        // Hapus karakter null bytes
        $input = str_replace("\0", '', $input);

        // Hapus control characters kecuali newline dan tab
        $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $input);

        // Trim whitespace berlebih
        $input = trim($input);

        // Batasi jumlah karakter berulang (mencegah spam)
        $input = preg_replace('/(.)\1{10,}/u', '$1$1$1', $input);

        // Batasi jumlah newline berurutan
        $input = preg_replace('/\n{4,}/', "\n\n\n", $input);

        return $input;
    }
}
