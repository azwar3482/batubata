<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XiaomiService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('XIAOMI_API_KEY', '');
        $this->model = env('XIAOMI_MODEL', 'mimo-v2.5-pro');
        $this->baseUrl = 'https://token-plan-sgp.xiaomimimo.com/v1/chat/completions';
    }

    /**
     * Kirim prompt ke Xiaomi API (OpenAI-compatible) dan dapatkan response
     */
    public function generateContent(string $systemPrompt, string $userMessage, array $history = []): ?array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'API key Xiaomi belum dikonfigurasi. Silakan tambahkan XIAOMI_API_KEY di .env',
            ];
        }

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];
        
        // Tambah history jika ada
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'assistant', 
                'content' => $msg['content']
            ];
        }
        
        // Tambah pesan user saat ini
        $messages[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model' => $this->model,
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

    /**
     * Cek apakah API key sudah dikonfigurasi
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }
}
