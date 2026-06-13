<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = min($request->input('limit', 20), 100);
        $page = $request->input('page', 1);

        $notifications = AppNotification::forUser($user->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        $items = $notifications->items();
        $data = array_map(fn($n) => [
            'id' => (string) $n->id,
            'title' => $n->title,
            'message' => $n->message,
            'type' => $n->type,
            'is_read' => $n->is_read,
            'action_url' => $n->action_url,
            'image_url' => $n->image_url,
            'metadata' => $n->metadata ?? [],
            'created_at' => $n->created_at->toISOString(),
        ], $items);

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markAsRead(Request $request, string $id)
    {
        $user = Auth::user();
        $notification = AppNotification::forUser($user->id)->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan.',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sudah dibaca.',
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();

        AppNotification::forUser($user->id)->unread()->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca.',
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $user = Auth::user();
        $notification = AppNotification::forUser($user->id)->find($id);

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan.',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }

    public function clearAll(Request $request)
    {
        $user = Auth::user();

        AppNotification::forUser($user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil dihapus.',
        ]);
    }

    public function unreadCount(Request $request)
    {
        $user = Auth::user();

        $count = AppNotification::forUser($user->id)->unread()->count();

        return response()->json([
            'data' => [
                'count' => $count,
            ],
        ]);
    }
}
