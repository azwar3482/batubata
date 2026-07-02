<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $laravelNotifications = $user->notifications();
        $appNotifications = AppNotification::forUser($user->id);

        $allNotifications = $laravelNotifications->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'type' => $n->type,
                'data' => (array) $n->data,
                'read_at' => $n->read_at,
                'created_at' => $n->created_at,
                'source' => 'laravel',
            ];
        });

        $appNotifs = $appNotifications->get()->map(function ($n) {
            return [
                'id' => 'app_' . $n->id,
                'type' => $n->type,
                'data' => [
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'url' => $n->action_url,
                    'icon' => 'bell',
                ],
                'read_at' => $n->is_read ? $n->updated_at : null,
                'created_at' => $n->created_at,
                'source' => 'app',
            ];
        });

        $merged = $allNotifications->concat($appNotifs)->sortByDesc('created_at')->values();

        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage() ?: 1;
        $paginated = $merged->slice(($currentPage - 1) * $perPage, $perPage);

        $notifications = new LengthAwarePaginator(
            $paginated,
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => route('notifications.index')]
        );

        return view('notifications.index', compact('notifications'));
    }

    public function readAll()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        AppNotification::forUser($user->id)->unread()->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi sudah dibaca');
    }

    public function read($id)
    {
        $user = Auth::user();

        if (str_starts_with($id, 'app_')) {
            $realId = str_replace('app_', '', $id);
            $notification = AppNotification::forUser($user->id)->findOrFail($realId);
            $notification->markAsRead();
        } else {
            $notification = $user->notifications()->findOrFail($id);
            $notification->markAsRead();
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (str_starts_with($id, 'app_')) {
            $realId = str_replace('app_', '', $id);
            $notification = AppNotification::forUser($user->id)->findOrFail($realId);
            $notification->delete();
        } else {
            $notification = $user->notifications()->findOrFail($id);
            $notification->delete();
        }

        return back()->with('success', 'Notifikasi berhasil dihapus');
    }
}
