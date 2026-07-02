<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Institution;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::latest()->paginate(10, ['*'], 'companies_page');
        $institutions = Institution::latest()->paginate(10, ['*'], 'institutions_page');

        // Allow appending parameters for pagination to work nicely with tabs
        $companies->appends($request->except('companies_page'));
        $institutions->appends($request->except('institutions_page'));

        return view('admin.verifications.index', compact('companies', 'institutions'));
    }
}
