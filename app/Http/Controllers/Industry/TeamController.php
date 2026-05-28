<?php

namespace App\Http\Controllers\Industry;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use App\Services\TeamManagementService;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamManagementService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index()
    {
        $data = $this->teamService->getTeamData();
        
        return view('industry.team', $data);
    }

    public function invite(InviteTeamMemberRequest $request)
    {
        $this->teamService->inviteMember($request->validated());

        return back()->with('success', "Undangan berhasil dikirim ke {$request->email}");
    }

    public function updateRole($id, UpdateTeamMemberRequest $request)
    {
        $this->teamService->updateMember($id, $request->validated());

        return back()->with('success', 'Role anggota tim berhasil diupdate');
    }

    public function remove($id)
    {
        $this->teamService->removeMember($id);

        return back()->with('success', 'Anggota tim berhasil dihapus');
    }
}
