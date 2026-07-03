<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['assessments', 'jobApplications'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(5)->withQueryString();

        // Single query untuk semua stats
        $statData = User::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN role = 'job_seeker' THEN 1 ELSE 0 END) as job_seeker,
            SUM(CASE WHEN role = 'industry' THEN 1 ELSE 0 END) as industry,
            SUM(CASE WHEN role = 'education' THEN 1 ELSE 0 END) as education,
            SUM(CASE WHEN role = 'course_vendor' THEN 1 ELSE 0 END) as course_vendor
        ")->first();

        $stats = [
            'total' => $statData->total,
            'job_seeker' => $statData->job_seeker,
            'industry' => $statData->industry,
            'education' => $statData->education,
            'course_vendor' => $statData->course_vendor,
        ];

        return view('admin.users', compact('users', 'stats'));
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:job_seeker,industry,education,admin,teacher,course_vendor',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:job_seeker,industry,education,admin,teacher,course_vendor',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }
}
