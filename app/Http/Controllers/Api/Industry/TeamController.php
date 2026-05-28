<?php

namespace App\Http\Controllers\Api\Industry;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Get recruitment team members.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            // If they are industry but no company record yet, create one
            $company = Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name . ' Corp',
                    'industry' => 'Tech',
                    'size' => '11-50 employees',
                    'website' => 'https://example.com'
                ]
            );
            
            $user->company_id = $company->id;
            $user->company_role = 'Owner';
            $user->save();
        }

        $members = User::where('company_id', $company->id)
            ->select('id', 'name', 'email', 'company_role', 'photo')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    /**
     * Invite/Add member to team by email.
     */
    public function invite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        /** @var \App\Models\User $owner */
        $owner = Auth::user();
        $company = $owner->company;

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus memiliki profil perusahaan terlebih dahulu.'
            ], 403);
        }

        $targetUser = User::where('email', $validated['email'])->first();

        if (!$targetUser) {
            return response()->json([
                'success' => false,
                'message' => 'User dengan email tersebut tidak ditemukan.'
            ], 404);
        }

        if ($targetUser->company_id && $targetUser->company_id != $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'User tersebut sudah bergabung dengan tim lain.'
            ], 400);
        }

        $targetUser->company_id = $company->id;
        $targetUser->company_role = $validated['role'];
        $targetUser->save();

        return response()->json([
            'success' => true,
            'message' => "{$targetUser->name} berhasil ditambahkan ke tim.",
            'data' => $targetUser
        ]);
    }

    /**
     * Update member role.
     */
    public function updateRole($id, Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string',
        ]);

        /** @var \App\Models\User $owner */
        $owner = Auth::user();
        $member = User::where('company_id', $owner->company_id)->findOrFail($id);

        if ($member->id === $owner->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah role Anda sendiri di sini.'
            ], 400);
        }

        $member->company_role = $validated['role'];
        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil diperbarui.'
        ]);
    }

    /**
     * Remove member from team.
     */
    public function remove($id)
    {
        /** @var \App\Models\User $owner */
        $owner = Auth::user();
        $member = User::where('company_id', $owner->company_id)->findOrFail($id);

        if ($member->id === $owner->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus diri sendiri dari tim.'
            ], 400);
        }

        $member->company_id = null;
        $member->company_role = null;
        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Anggota tim berhasil dihapus.'
        ]);
    }
}
