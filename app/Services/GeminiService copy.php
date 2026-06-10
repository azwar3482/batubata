<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/' . $this->model;
    }

    /**
     * Kirim prompt ke Gemini API dan dapatkan response
     */
    public function generateContent(string $systemPrompt, string $userMessage, array $history = []): ?array
    {
        // -------------------------------------------------------------
        // IMPLEMENTASI SEMENTARA: XIAOMI / OPENAI-COMPATIBLE API
        // -------------------------------------------------------------
        $xiaomiKey = env('XIAOMI_API_KEY');
        
        if (!empty($xiaomiKey)) {
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt]
            ];
            
            foreach ($history as $msg) {
                // OpenAI format: 'assistant' (bukan 'model' seperti di Gemini)
                $messages[] = [
                    'role' => $msg['role'] === 'user' ? 'user' : 'assistant', 
                    'content' => $msg['content']
                ];
            }
            
            $messages[] = [
                'role' => 'user',
                'content' => $userMessage
            ];

            try {
                // URL API Endpoint OpenAI-compatible dari Xiaomi (menggunakan Token Plan SGP)
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $xiaomiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post('https://token-plan-sgp.xiaomimimo.com/v1/chat/completions', [
                    'model' => env('XIAOMI_MODEL', 'mimo-v2.5-pro'), // Berdasarkan konfigurasi Anda (MiMo V2.5 Pro)
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 2048,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'success' => true,
                        'text' => $data['choices'][0]['message']['content'] ?? '',
                        'usage' => $data['usage'] ?? null,
                    ];
                }

                Log::error('Xiaomi API error: ' . $response->body());
                return [
                    'success' => false,
                    'error' => 'Xiaomi API error: ' . $response->status(),
                ];
            } catch (\Exception $e) {
                Log::error('Xiaomi API exception: ' . $e->getMessage());
                return [
                    'success' => false,
                    'error' => 'Gagal menghubungi Xiaomi API: ' . $e->getMessage(),
                ];
            }
        }

        // -------------------------------------------------------------
        // IMPLEMENTASI ASLI: GOOGLE GEMINI API (Dihide/Komen)
        // Nanti jika ingin dipakai, hapus block komentar /* ... */ ini
        // dan hapus/komen block Xiaomi di atas.
        // -------------------------------------------------------------
        /*
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'API key Gemini belum dikonfigurasi. Silakan tambahkan GEMINI_API_KEY di .env',
            ];
        }

        $contents = [];

        // Tambah history jika ada
        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg['content']]],
            ];
        }

        // Tambah pesan user saat ini
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        try {
            $response = Http::timeout(30)->post(
                $this->baseUrl . ':generateContent?key=' . $this->apiKey,
                [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topP' => 0.9,
                        'maxOutputTokens' => 2048,
                    ],
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                return [
                    'success' => true,
                    'text' => $text,
                    'usage' => $data['usageMetadata'] ?? null,
                ];
            }

            Log::error('Gemini API error: ' . $response->body());
            return [
                'success' => false,
                'error' => 'Gemini API error: ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Gemini API exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Gagal menghubungi Gemini API: ' . $e->getMessage(),
            ];
        }
        */

        return [
            'success' => false,
            'error' => 'API Key tidak ditemukan. Pastikan XIAOMI_API_KEY atau GEMINI_API_KEY terisi di .env'
        ];
    }

    /**
     * Cek apakah API key sudah dikonfigurasi
     */
    public function isConfigured(): bool
    {
        return !empty(env('XIAOMI_API_KEY')) || !empty($this->apiKey);
    }
}
