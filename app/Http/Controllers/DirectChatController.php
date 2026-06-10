<?php

namespace App\Http\Controllers;

use App\Models\DirectConversation;
use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectChatController extends Controller
{
    /**
     * Initiate a conversation from Industry to Seeker.
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:users,id',
        ]);

        $industry = Auth::user();
        if (!$industry->isIndustryOrStaff()) {
            abort(403, 'Hanya pihak industri yang dapat memulai obrolan.');
        }

        $candidateId = $request->candidate_id;
        $candidate = User::findOrFail($candidateId);

        if (!$candidate->isJobSeeker()) {
            return back()->with('error', 'Obrolan hanya dapat dimulai dengan pencari kerja.');
        }

        // Cari obrolan yang sudah ada atau buat baru
        $conversation = DirectConversation::firstOrCreate([
            'industry_id' => $industry->id,
            'job_seeker_id' => $candidateId,
        ]);

        return redirect()->route('industry.chats.index', ['id' => $conversation->id]);
    }

    /**
     * Display chats for Industry users.
     */
    public function industryIndex(Request $request, $id = null)
    {
        $user = Auth::user();
        if (!$user->isIndustryOrStaff()) {
            abort(403);
        }

        // Ambil daftar percakapan terurut berdasarkan pesan terakhir
        $conversations = DirectConversation::where('industry_id', $user->id)
            ->with(['jobSeeker', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderByRaw('COALESCE(last_message_at, updated_at) DESC')
            ->get();

        $activeConversation = null;
        $messages = collect();

        if ($id) {
            $activeConversation = DirectConversation::where('industry_id', $user->id)
                ->where('id', $id)
                ->with('jobSeeker')
                ->firstOrFail();

            // Tandai pesan dari Seeker sebagai dibaca
            DirectMessage::where('conversation_id', $activeConversation->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = DirectMessage::where('conversation_id', $activeConversation->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('industry.chats.index', compact('conversations', 'activeConversation', 'messages'));
    }

    /**
     * Display chats for Job Seekers.
     */
    public function seekerIndex(Request $request, $id = null)
    {
        $user = Auth::user();
        if (!$user->isJobSeeker()) {
            abort(403);
        }

        // Ambil daftar percakapan terurut berdasarkan pesan terakhir
        $conversations = DirectConversation::where('job_seeker_id', $user->id)
            ->with(['industry.company', 'messages' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderByRaw('COALESCE(last_message_at, updated_at) DESC')
            ->get();

        $activeConversation = null;
        $messages = collect();

        if ($id) {
            $activeConversation = DirectConversation::where('job_seeker_id', $user->id)
                ->where('id', $id)
                ->with('industry.company')
                ->firstOrFail();

            // Tandai pesan dari Industri sebagai dibaca
            DirectMessage::where('conversation_id', $activeConversation->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $messages = DirectMessage::where('conversation_id', $activeConversation->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('seeker.chats.index', compact('conversations', 'activeConversation', 'messages'));
    }

    /**
     * Send a message inside a conversation.
     */
    public function sendMessage(Request $request, DirectConversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $user = Auth::user();

        // Validasi keanggotaan percakapan
        if ($conversation->industry_id !== $user->id && $conversation->job_seeker_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke percakapan ini.');
        }

        // Simpan pesan baru
        $message = DirectMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Update timestamp pesan terakhir
        $conversation->update([
            'last_message_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}
