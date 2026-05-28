<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\CVAnalysisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
Route::post('/login/google', [AuthController::class, 'loginGoogle'])->middleware('throttle:6,1');

Route::get('/skill-keywords', function () {
    $keywords = \App\Models\SkillKeyword::where('is_active', true)->get();
    $grouped = [];
    foreach ($keywords as $kw) {
        if (!isset($grouped[$kw->category])) {
            $grouped[$kw->category] = [];
        }
        $grouped[$kw->category][] = $kw->keyword;
    }
    return response()->json($grouped);
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('throttle:6,1');
    
    // User & Profile
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::post('/user/profile/update', [ProfileController::class, 'update']);
    Route::get('/user/skills', [ProfileController::class, 'skills']);
    
    // Dashboard
    Route::get('/home/data', [HomeController::class, 'index']);

    // CV Analysis
    Route::post('/cv/upload', [CVAnalysisController::class, 'uploadAndAnalyze']);
    Route::get('/cv/analysis/{userId}', [CVAnalysisController::class, 'getAnalysis']);

    // Assessments (Using main controllers but returning JSON where possible)
    // Note: If these return views, we might need dedicated Api AssessmentController
    Route::get('/assessments/positions', [AssessmentController::class, 'positions']);
    Route::get('/assessments/skills', [AssessmentController::class, 'skills']);
    Route::post('/assessments/submit', [AssessmentController::class, 'submit']);
    Route::get('/assessments/history', [AssessmentController::class, 'history']);
    Route::get('/assessments/{id}/result', [AssessmentController::class, 'result']);

    // Jobs
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    Route::post('/jobs/{id}/apply', [JobController::class, 'apply']);
    Route::get('/jobs/my-applications', [JobController::class, 'myApplications']);

    // Courses
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll']);
    Route::get('/courses/my-progress', [CourseController::class, 'myProgress']);

    // Roadmap
    Route::get('/roadmap', [RoadmapController::class, 'index']);
    Route::put('/roadmap/{id}/complete', [RoadmapController::class, 'complete']);

    // Admin Routes
    Route::prefix('admin')->middleware('can:access-admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
        Route::get('/users/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
        
        // Competencies
        Route::get('/competencies', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'index']);
        Route::get('/competencies/{competency}', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'show']);
    });

    // Industry Routes
    Route::prefix('industry')->group(function () {
        Route::get('/jobs', [\App\Http\Controllers\Api\Industry\JobPostingController::class, 'index']);
        Route::post('/jobs', [\App\Http\Controllers\Api\Industry\JobPostingController::class, 'store']);
        Route::get('/candidates', [\App\Http\Controllers\Api\Industry\CandidateController::class, 'index']);
        Route::get('/candidates/{id}', [\App\Http\Controllers\Api\Industry\CandidateController::class, 'show']);
        Route::get('/team', [\App\Http\Controllers\Api\Industry\TeamController::class, 'index']);
        Route::post('/team/invite', [\App\Http\Controllers\Api\Industry\TeamController::class, 'invite']);
        Route::put('/team/{id}/role', [\App\Http\Controllers\Api\Industry\TeamController::class, 'updateRole']);
        Route::delete('/team/{id}', [\App\Http\Controllers\Api\Industry\TeamController::class, 'remove']);
    });

    Route::prefix('education')->group(function () {
        Route::get('/analytics', [\App\Http\Controllers\Api\Education\AnalyticsController::class, 'index']);
        
        // Partners
        Route::get('/partners', [\App\Http\Controllers\Api\Education\PartnersController::class, 'index']);
        Route::get('/partners/{id}', [\App\Http\Controllers\Api\Education\PartnersController::class, 'show']);
        
        // Collaboration
        Route::get('/collaboration/types', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'index']);
        Route::post('/collaboration', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'store']);
        Route::get('/collaboration/history', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'history']);
    });
});
