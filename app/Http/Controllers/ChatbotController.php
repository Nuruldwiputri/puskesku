<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import Http Client Laravel
use Illuminate\Support\Facades\Log; // Import Log untuk debugging

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000', // Validasi pesan dari user
        ]);

        $userMessage = $request->input('message');

        try {
            // Panggil Groq API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.groq.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.groq.base_url') . '/chat/completions', [
                'model' => config('services.groq.model'), // Menggunakan model dari config
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah asisten chatbot untuk Puskesmas Online. Berikan informasi yang relevan dan membantu tentang jadwal dokter, cara membuat janji temu, atau informasi umum tentang puskesmas. Jawab pertanyaan dengan singkat dan jelas. Jangan memberikan nasihat medis langsung atau diagnosa. Selalu arahkan pengguna untuk membuat janji temu atau berkonsultasi dengan dokter untuk masalah kesehatan.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage,
                    ],
                ],
                'temperature' => 0.7, // Tingkat kreativitas jawaban (0.0-1.0)
                'max_tokens' => 200, // Batas panjang jawaban
            ]);

            // Pastikan respons berhasil dan ada konten
            if ($response->successful() && isset($response->json()['choices'][0]['message']['content'])) {
                $aiResponse = $response->json()['choices'][0]['message']['content'];
                return response()->json(['reply' => $aiResponse]);
            } else {
                Log::error('Groq API Error: ' . $response->body());
                return response()->json(['error' => 'Gagal mendapatkan respons dari chatbot. Silakan coba lagi nanti.'], 500);
            }

        } catch (\Exception $e) {
            Log::error('Chatbot Controller Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan pada server. Silakan coba lagi.'], 500);
        }
    }
}