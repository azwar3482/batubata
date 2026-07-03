<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CourseVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            return redirect()->route('vendor.dashboard');
        }

        $query = $vendor->teachers()->withCount(['teacherCourses', 'teacherProfile']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $teachers = $query->paginate(10);

        return view('vendor.teachers.index', compact('vendor', 'teachers'));
    }

    public function invite(Request $request)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // In a real application, we would send an invite email with a registration token.
        // For simplicity/simulation, we will create the teacher account immediately with a default password.
        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'status' => 'active',
            'vendor_id' => $vendor->id,
        ]);

        // Create teacher profile skeleton
        $teacher->teacherProfile()->create([
            'bio' => 'Guru terafiliasi dengan vendor ' . $vendor->name,
        ]);

        return back()->with('success', "Guru {$teacher->name} berhasil diundang dan didaftarkan.");
    }

    public function toggleStatus($id)
    {
        $vendor = Auth::user()->ownedVendor;
        if (!$vendor) {
            abort(403);
        }

        $teacher = User::where('vendor_id', $vendor->id)->where('role', 'teacher')->findOrFail($id);
        
        $newStatus = $teacher->status === 'active' ? 'inactive' : 'active';
        $teacher->update(['status' => $newStatus]);

        return back()->with('success', "Status guru {$teacher->name} berhasil diubah menjadi " . ($newStatus === 'active' ? 'Aktif' : 'Non-Aktif') . ".");
    }
}
