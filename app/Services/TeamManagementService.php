<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTeamInviteJob;

class TeamManagementService
{
    public function getCompanyIdForUser($user)
    {
        if ($user->isIndustry()) {
            if (!$user->company) {
                // Lazily create company for this industry user if it doesn't exist
                $company = \App\Models\Company::create([
                    'user_id' => $user->id,
                    'name' => $user->name . ' Company',
                    'industry' => 'Other',
                    'size' => '1-50',
                ]);
                $user->load('company');
                return $company->id;
            }
            return $user->company->id;
        }

        return $user->company_id;
    }

    public function getTeamData()
    {
        $user = Auth::user();
        $companyId = $this->getCompanyIdForUser($user);

        $availableRoles = [
            'staf_hr_manager' => 'Staf HR Manager',
            'staf_recruiter' => 'Staf Recruiter',
            'staf_talent_sourcer' => 'Staf Talent Sourcer',
            'staf_interviewer' => 'Staf Interviewer',
        ];

        $roleDescriptions = [
            'staf_hr_manager' => 'Full access to all recruitment features',
            'staf_recruiter' => 'Can view candidates and schedule interviews',
            'staf_talent_sourcer' => 'Can only view candidate profiles',
            'staf_interviewer' => 'Can view assigned candidates and submit feedback',
        ];

        $permissions = [
            'post_jobs' => 'Posting & Manage Jobs',
            'view_candidates' => 'View Candidate Profiles',
            'manage_applications' => 'Manage Applications',
            'schedule_interview' => 'Schedule Interviews',
            'submit_feedback' => 'Submit Interview Feedback',
            'view_reports' => 'View Recruitment Reports',
        ];

        if (!$companyId) {
            return [
                'teamMembers' => collect(),
                'availableRoles' => $availableRoles,
                'roleDescriptions' => $roleDescriptions,
                'permissions' => $permissions
            ];
        }

        $members = \App\Models\User::where('company_id', $companyId)
            ->where('role', 'like', 'staf_%')
            ->get();

        $teamMembers = $members->map(function ($member) {
            $names = explode(' ', trim($member->name));
            $avatar = count($names) > 1 
                ? strtoupper(substr($names[0], 0, 1) . substr(end($names), 0, 1))
                : strtoupper(substr($names[0], 0, 2));

            $roleLabels = [
                'staf_hr_manager' => 'Staf HR Manager',
                'staf_recruiter' => 'Staf Recruiter',
                'staf_talent_sourcer' => 'Staf Talent Sourcer',
                'staf_interviewer' => 'Staf Interviewer'
            ];

            $rolePermissions = [
                'staf_hr_manager' => ['post_jobs', 'view_candidates', 'manage_applications', 'schedule_interview', 'submit_feedback', 'view_reports'],
                'staf_recruiter' => ['view_candidates', 'schedule_interview', 'submit_feedback'],
                'staf_talent_sourcer' => ['view_candidates'],
                'staf_interviewer' => ['view_candidates', 'submit_feedback']
            ];

            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'role' => $member->role,
                'avatar' => $avatar,
                'permissions' => $member->custom_permissions ?? ($rolePermissions[$member->role] ?? []),
                'status' => $member->status ?? 'active',
                'last_active' => $member->updated_at,
            ];
        });

        return compact('teamMembers', 'availableRoles', 'permissions', 'roleDescriptions');
    }

    public function inviteMember(array $validatedData)
    {
        $user = Auth::user();
        $companyId = $this->getCompanyIdForUser($user);

        if (!$companyId) {
            throw new \Exception('User does not have an associated company.');
        }

        // Create the user record in database
        $member = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'company_id' => $companyId,
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
            'email_verified_at' => now(), // Auto-verify for simplicity
        ]);

        return $member;
    }

    public function updateMember($id, array $validatedData)
    {
        $member = \App\Models\User::findOrFail($id);
        $member->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'status' => $validatedData['status'],
            'role' => $validatedData['role'],
            'custom_permissions' => $validatedData['permissions'] ?? null,
        ]);
        return true;
    }

    public function removeMember($id)
    {
        $member = \App\Models\User::findOrFail($id);
        $member->delete();
        return true;
    }
}
