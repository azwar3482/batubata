<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PartnerService;

class PartnersController extends Controller
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function index()
    {
        $data = $this->partnerService->getPartnersData();
        
        return view('education.partners', $data);
    }

    public function show($id)
    {
        $partner = $this->partnerService->getPartnerDetail($id);

        if (!$partner) {
            abort(404);
        }

        return view('education.partners-detail', compact('partner'));
    }
}
