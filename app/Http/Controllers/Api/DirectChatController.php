<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DirectConversation;
use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DirectChatController extends Controller
{
    /**
     * Get all active conversations for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = DirectConversation::query();
        
        if ($user->isJobSeeker()) {
            $query->where('job_seeker_id', $user->id)
                ->with(['industry.company']);
        } else {
            // Industry or Staff
            // Note: Staff might use company owner user_id or their own if scoped
            $query->where('industry_id', $user->id)
                ->with(['jobSeeker']);
        }
        
        $conversations = $query->with(['messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->orderByRaw('COALESCE(last_message_at, updated_at) DESC')
            ->get();

        // Calculate unread count for each conversation
        $data = $conversations->map(function ($conv) use ($user) {
            $unreadCount = DirectMessage::where('conversation_id', $conv->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
                
            $lastMessage = $conv->messages->first();
            
            // Format participant details
            $title = '';
            $avatar = null;
            if ($user->isJobSeeker()) {
                $title = $conv->industry->company->name ?? $conv->industry->name;
                $avatar = $conv->industry->photo ? asset('storage/' . $conv->industry->photo) : null;
            } else {
                $title = $conv->jobSeeker->name;
                $avatar = $conv->jobSeeker->photo ? asset('storage/' . $conv->jobSeeker->photo) : null;
            }

            return [
                'id' => $conv->id,
                'title' => $title,
                'avatar' => $avatar,
                'unread_count' => $unreadCount,
                'last_message' => $lastMessage ? [
                    'message' => $lastMessage->message,
                    'created_at' => $lastMessage->created_at,
                    'is_me' => $lastMessage->sender_id === $user->id,
                ] : null,
                'updated_at' => $conv->last_message_at ?? $conv->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get all messages in a specific conversation.
     */
    public function messages($id)
    {
        $user = Auth::user();
        $conversation = DirectConversation::findOrFail($id);

        if ($conversation->industry_id !== $user->id && $conversation->job_seeker_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke percakapan ini.'
            ], 403);
        }

        // Mark incoming messages as read
        DirectMessage::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = DirectMessage::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_me' => $msg->sender_id === $user->id,
                    'created_at' => $msg->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Send a message to a conversation.
     */
    public function send(Request $request, $id)
    {
        $user = Auth::user();
        $conversation = DirectConversation::findOrFail($id);

        if ($conversation->industry_id !== $user->id && $conversation->job_seeker_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke percakapan ini.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $message = DirectMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_me' => true,
                'created_at' => $message->created_at,
            ]
        ]);
    }

    /**
     * Initiate a conversation from Industry to Seeker or vice versa.
     */
    public function initiate(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'target_user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $targetUser = User::findOrFail($request->target_user_id);

        // Determine who is seeker and who is industry
        $seekerId = null;
        $industryId = null;

        if ($user->isJobSeeker() && $targetUser->isIndustryOrStaff()) {
            $seekerId = $user->id;
            $industryId = $targetUser->id;
        } elseif ($user->isIndustryOrStaff() && $targetUser->isJobSeeker()) {
            $seekerId = $targetUser->id;
            $industryId = $user->id;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Obrolan hanya dapat dilakukan antara pencari kerja dan pihak industri.'
            ], 400);
        }

        $conversation = DirectConversation::firstOrCreate([
            'industry_id' => $industryId,
            'job_seeker_id' => $seekerId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Obrolan berhasil diinisiasi.',
            'data' => [
                'conversation_id' => $conversation->id
            ]
        ]);
    }
}
