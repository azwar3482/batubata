<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiAnalysisService;

class ExampleController extends Controller
{
    public function index(AiAnalysisService $aiService)
    {
        $result = $aiService->analyze("data");
        return $result;
    }
}
