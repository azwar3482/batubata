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

    // Direct Chats
    Route::get('/chats/sessions', [\App\Http\Controllers\Api\DirectChatController::class, 'index']);
    Route::get('/chats/{id}/messages', [\App\Http\Controllers\Api\DirectChatController::class, 'messages']);
    Route::post('/chats/{id}/send', [\App\Http\Controllers\Api\DirectChatController::class, 'send']);
    Route::post('/chats/initiate', [\App\Http\Controllers\Api\DirectChatController::class, 'initiate']);

    // Seeker TPA
    Route::get('/seeker/tpa', [\App\Http\Controllers\Api\SeekerTpaController::class, 'index']);
    Route::get('/seeker/tpa/{id}', [\App\Http\Controllers\Api\SeekerTpaController::class, 'show']);
    Route::post('/seeker/tpa/{id}/start', [\App\Http\Controllers\Api\SeekerTpaController::class, 'start']);
    Route::get('/seeker/tpa/{id}/questions', [\App\Http\Controllers\Api\SeekerTpaController::class, 'questions']);
    Route::post('/seeker/tpa/{id}/answer', [\App\Http\Controllers\Api\SeekerTpaController::class, 'saveAnswer']);
    Route::post('/seeker/tpa/{id}/submit', [\App\Http\Controllers\Api\SeekerTpaController::class, 'submit']);
    Route::post('/seeker/tpa/{id}/respond-offline', [\App\Http\Controllers\Api\SeekerTpaController::class, 'respondOffline']);

    // Admin Routes
    Route::prefix('admin')->middleware('can:access-admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\Api\Admin\UserController::class, 'store']);
        Route::get('/users/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
        Route::put('/users/{id}', [\App\Http\Controllers\Api\Admin\UserController::class, 'update']);
        Route::delete('/users/{id}', [\App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);
        
        // Competencies
        Route::get('/competencies', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'index']);
        Route::post('/competencies', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'store']);
        Route::get('/competencies/{competency}', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'show']);
        Route::put('/competencies/{id}', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'update']);
        Route::delete('/competencies/{id}', [\App\Http\Controllers\Api\Admin\CompetencyController::class, 'destroy']);

        // Categories
        Route::get('/categories', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'index']);
        Route::post('/categories', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'store']);
        Route::get('/categories/{id}', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'show']);
        Route::put('/categories/{id}', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [\App\Http\Controllers\Api\Admin\CategoryController::class, 'destroy']);

        // Positions
        Route::get('/positions', [\App\Http\Controllers\Api\Admin\PositionController::class, 'index']);
        Route::post('/positions', [\App\Http\Controllers\Api\Admin\PositionController::class, 'store']);
        Route::get('/positions/{id}', [\App\Http\Controllers\Api\Admin\PositionController::class, 'show']);
        Route::put('/positions/{id}', [\App\Http\Controllers\Api\Admin\PositionController::class, 'update']);
        Route::delete('/positions/{id}', [\App\Http\Controllers\Api\Admin\PositionController::class, 'destroy']);

        // Skill Keywords
        Route::get('/skill-keywords-master', [\App\Http\Controllers\Api\Admin\SkillKeywordController::class, 'index']);
        Route::post('/skill-keywords-master', [\App\Http\Controllers\Api\Admin\SkillKeywordController::class, 'store']);
        Route::get('/skill-keywords-master/{id}', [\App\Http\Controllers\Api\Admin\SkillKeywordController::class, 'show']);
        Route::put('/skill-keywords-master/{id}', [\App\Http\Controllers\Api\Admin\SkillKeywordController::class, 'update']);
        Route::delete('/skill-keywords-master/{id}', [\App\Http\Controllers\Api\Admin\SkillKeywordController::class, 'destroy']);

        // External Courses
        Route::get('/external-courses', [\App\Http\Controllers\Api\Admin\ExternalCourseController::class, 'index']);
        Route::post('/external-courses', [\App\Http\Controllers\Api\Admin\ExternalCourseController::class, 'store']);
        Route::get('/external-courses/{id}', [\App\Http\Controllers\Api\Admin\ExternalCourseController::class, 'show']);
        Route::put('/external-courses/{id}', [\App\Http\Controllers\Api\Admin\ExternalCourseController::class, 'update']);
        Route::delete('/external-courses/{id}', [\App\Http\Controllers\Api\Admin\ExternalCourseController::class, 'destroy']);
    });

    // Industry Routes
    Route::prefix('industry')->middleware('role:industry,staf_hr_manager,staf_recruiter,staf_talent_sourcer,staf_interviewer')->group(function () {
        Route::get('/jobs', [\App\Http\Controllers\Api\Industry\JobPostingController::class, 'index']);
        Route::post('/jobs', [\App\Http\Controllers\Api\Industry\JobPostingController::class, 'store']);
        Route::get('/candidates', [\App\Http\Controllers\Api\Industry\CandidateController::class, 'index']);
        Route::get('/candidates/{id}', [\App\Http\Controllers\Api\Industry\CandidateController::class, 'show']);
        Route::get('/team', [\App\Http\Controllers\Api\Industry\TeamController::class, 'index']);
        Route::post('/team/invite', [\App\Http\Controllers\Api\Industry\TeamController::class, 'invite']);
        Route::put('/team/{id}/role', [\App\Http\Controllers\Api\Industry\TeamController::class, 'updateRole']);
        Route::delete('/team/{id}', [\App\Http\Controllers\Api\Industry\TeamController::class, 'remove']);

        // Industry TPA
        Route::get('/tpa/tests', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'index']);
        Route::post('/tpa/tests', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'store']);
        Route::put('/tpa/tests/{id}', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'update']);
        Route::delete('/tpa/tests/{id}', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'destroy']);
        Route::post('/applications/{id}/invite-tpa', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'inviteCandidate']);
        Route::get('/tpa/results', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'results']);
        Route::get('/tpa/results/{id}', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'showResult']);
        Route::get('/tpa/questions', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'questions']);
        Route::post('/tpa/questions', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'storeQuestion']);
        Route::put('/tpa/questions/{id}', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'updateQuestion']);
        Route::delete('/tpa/questions/{id}', [\App\Http\Controllers\Api\Industry\TpaManagementController::class, 'destroyQuestion']);
    });

    // Education Routes
    Route::prefix('education')->middleware('role:education')->group(function () {
        Route::get('/analytics', [\App\Http\Controllers\Api\Education\AnalyticsController::class, 'index']);
        Route::get('/students', [\App\Http\Controllers\Api\Education\StudentController::class, 'index']);
        
        // Programs
        Route::get('/programs', [\App\Http\Controllers\Api\Education\ProgramController::class, 'index']);
        Route::post('/programs', [\App\Http\Controllers\Api\Education\ProgramController::class, 'store']);
        
        // Partners
        Route::get('/partners', [\App\Http\Controllers\Api\Education\PartnersController::class, 'index']);
        Route::get('/partners/{id}', [\App\Http\Controllers\Api\Education\PartnersController::class, 'show']);
        
        // Collaboration
        Route::get('/collaboration/types', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'index']);
        Route::post('/collaboration', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'store']);
        Route::get('/collaboration/history', [\App\Http\Controllers\Api\Education\CollaborationController::class, 'history']);
    });

    // Teacher Routes
    Route::prefix('teacher')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Teacher\DashboardController::class, 'index']);
        
        // Courses
        Route::get('/courses', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'index']);
        Route::post('/courses', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'store']);
        Route::get('/courses/{id}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'show']);
        Route::put('/courses/{id}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'update']);
        Route::delete('/courses/{id}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'destroy']);
        Route::post('/courses/{id}/publish', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'publish']);
        Route::post('/courses/{id}/unpublish', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'unpublish']);
        
        // Modules
        Route::post('/courses/{courseId}/modules', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'storeModule']);
        Route::put('/modules/{moduleId}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'updateModule']);
        Route::delete('/modules/{moduleId}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'destroyModule']);
        
        // Materials
        Route::post('/modules/{moduleId}/materials', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'storeMaterial']);
        Route::put('/materials/{materialId}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'updateMaterial']);
        Route::delete('/materials/{materialId}', [\App\Http\Controllers\Api\Teacher\CourseController::class, 'destroyMaterial']);
        
        // Classes
        Route::get('/classes', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'index']);
        Route::post('/classes', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'store']);
        Route::get('/classes/{id}', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'show']);
        Route::put('/classes/{id}', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'update']);
        Route::delete('/classes/{id}', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'destroy']);
        Route::post('/classes/{classId}/enroll', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'enrollStudent']);
        Route::put('/enrollments/{enrollmentId}/status', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'updateStudentStatus']);
        Route::delete('/enrollments/{enrollmentId}', [\App\Http\Controllers\Api\Teacher\ClassController::class, 'removeStudent']);
        
        // Submissions
        Route::get('/submissions', [\App\Http\Controllers\Api\Teacher\SubmissionController::class, 'index']);
        Route::get('/submissions/{id}', [\App\Http\Controllers\Api\Teacher\SubmissionController::class, 'show']);
        Route::post('/submissions/{id}/grade', [\App\Http\Controllers\Api\Teacher\SubmissionController::class, 'grade']);
    });
});
