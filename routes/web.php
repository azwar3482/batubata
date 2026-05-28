<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Education\DashboardController as EducationDashboardController;
use App\Http\Controllers\Education\PartnersController;
use App\Http\Controllers\Industry\DashboardController as IndustryDashboardController;
use App\Http\Controllers\Industry\DashboardController as IndustryDashboard;
use App\Http\Controllers\Industry\JobPostingController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// Nanti: Route::post('/roadmap/{id}/complete', ...);

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Jobs
// Route::get('/jobs', [App\Http\Controllers\DashboardController::class, 'jobs'])->name('jobs.index');

// Roadmap
// Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap.index');
// Route::put('/roadmap/{id}/complete', [RoadmapController::class, 'complete'])->name('roadmap.complete');

// Assessment Start Page (Halaman pengantar)
// Route::get('/assessment', function () {
// return view('assessment.start');
// })->name('assessment.start');
// Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
// Route::get('/assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');
// Route::get('/assessment/history', [AssessmentController::class, 'history'])->name('assessment.history');





Route::prefix('industry')->name('industry.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Industry\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('education')->name('education.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Education\DashboardController::class, 'index'])->name('dashboard');
});



Route::put('/notifications/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.read-all')->middleware('auth');
// Group Industri
Route::prefix('industry')->name('industry.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [IndustryDashboard::class, 'index'])->name('dashboard');
    Route::get('/jobs', [JobPostingController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [JobPostingController::class, 'create'])->name('jobs.create');
    Route::post('/jobs/store', [JobPostingController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}', [JobPostingController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobPostingController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobPostingController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/jobs/{id}/report', [JobPostingController::class, 'downloadReport'])->name('jobs.report');
});



// Route yang butuh Auth & Redirect Role
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Umum (Akan di-redirect oleh middleware sesuai role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Tambahkan di dalam group auth
    Route::post('/profile/cv-upload', [ProfileController::class, 'uploadCv'])->name('profile.cv.upload');
    Route::post('/profile/photo-upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::post('/profile/documents-upload', [ProfileController::class, 'uploadDocuments'])->name('profile.documents.upload');
    Route::delete('/profile/documents/{id}', [ProfileController::class, 'deleteDocument'])->name('profile.documents.destroy');
    Route::post('/profile/update-location', [ProfileController::class, 'updateLocation'])->name('profile.location.update');

    // =====================
    // JOB SEEKER ROUTES
    // =====================
    Route::prefix('seeker')->name('seeker.')->group(function () {

        // routes/web.php - inside seeker group

        // Tambahkan di dalam admin group
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/settings/competency/{id}', [App\Http\Controllers\Admin\SettingsController::class, 'updateCompetency'])->name('admin.settings.competency.update');
        Route::post('/settings/system', [App\Http\Controllers\Admin\SettingsController::class, 'updateSystemSettings'])->name('admin.settings.system');
        Route::post('/settings/sync', [App\Http\Controllers\Admin\SettingsController::class, 'syncCompetencies'])->name('admin.settings.sync');

        // Tambahkan di dalam education group
        Route::get('/programs', [App\Http\Controllers\Education\ProgramController::class, 'index'])->name('education.programs');
        Route::get('/programs/create', [App\Http\Controllers\Education\ProgramController::class, 'create'])->name('education.programs.create');
        Route::post('/programs', [App\Http\Controllers\Education\ProgramController::class, 'store'])->name('education.programs.store');

        // Education Program Create Route (inside education group)
        // Route::get('/programs/create', [App\Http\Controllers\Education\ProgramController::class, 'create'])->name('education.programs.create');




        // Tambahkan di dalam seeker group
        Route::get('/jobs/all', [App\Http\Controllers\JobController::class, 'index'])->name('jobs.all');
        Route::get('/jobs/my-applications', [DashboardController::class, 'myApplications'])->name('jobs.applications');

        // Rute Dinamis (harus di bawah rute statis agar tidak tabrakan)
        Route::get('/jobs/{id}', [App\Http\Controllers\JobController::class, 'show'])->name('jobs.detail');
        Route::get('/jobs/{id}/skill-match', [JobController::class, 'skillMatch'])->name('jobs.skill-match');




        // Asesmen
        Route::get('/assessment', function () {
            return view('assessment.start');
        })->name('assessment.start');
        Route::get('/assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');
        Route::post('/assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
        Route::get('/assessment/questions', [AssessmentController::class, 'questions'])->name('assessment.questions');
        Route::post('/assessment/submit', [AssessmentController::class, 'submit'])->name('assessment.submit');
        Route::get('/assessment/result/{id}', [AssessmentController::class, 'result'])->name('assessment.result');

        Route::get('/assessment/history', [AssessmentController::class, 'history'])->name('assessment.history');
        Route::get('/assessment/retake/{id}', [AssessmentController::class, 'retake'])->name('assessment.retake');

        // Roadmap
        Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap.index');
        Route::post('/roadmap/generate/{id}', [RoadmapController::class, 'generate'])->name('roadmap.generate');
        Route::put('/roadmap/{id}/complete', [RoadmapController::class, 'complete'])->name('roadmap.complete');

        // Jobs
        Route::get('/jobs', [DashboardController::class, 'jobs'])->name('jobs.index');
        Route::post('/jobs/{id}/apply', [DashboardController::class, 'applyJob'])->name('jobs.apply');
        Route::post('/jobs/{id}/save', [DashboardController::class, 'saveJob'])->name('jobs.save');
        Route::delete('/jobs/{id}/withdraw', [DashboardController::class, 'withdrawApplication'])->name('jobs.withdraw');
        // Courses
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

        // Reports
        Route::get('/reports/assessment/{id}/pdf', [ReportController::class, 'downloadAssessment'])->name('reports.assessment.pdf');
    });

    // =====================
    // ADMIN ROUTES
    // =====================
    Route::prefix('admin')->name('admin.')->middleware('can:access-admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/competencies', [AdminDashboardController::class, 'competencies'])->name('competencies');
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    });

    // =====================
    // INDUSTRY ROUTES
    // =====================
    Route::prefix('industry')->name('industry.')->group(function () {
        Route::get('/dashboard', [IndustryDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/report', [IndustryDashboardController::class, 'downloadReport'])->name('dashboard.report');
        Route::get('/jobs/create', [JobPostingController::class, 'create'])->name('jobs.create');
        Route::post('/jobs/store', [JobPostingController::class, 'store'])->name('jobs.store');
        Route::get('/candidates', function () {
            return view('industry.candidates');
        })->name('candidates');
        Route::get('/candidates/{id}', [App\Http\Controllers\Industry\CandidateController::class, 'show'])->name('candidates.show');
        Route::put('/applications/{id}/status', [App\Http\Controllers\Industry\CandidateController::class, 'updateStatus'])->name('applications.update-status');
        Route::get('/guide', function () {
            return view('industry.guide');
        })->name('guide');

        // Team Management
        Route::get('/team', [App\Http\Controllers\Industry\TeamController::class, 'index'])->name('team');
        Route::post('/team/invite', [App\Http\Controllers\Industry\TeamController::class, 'invite'])->name('team.invite');
        Route::put('/team/{id}/role', [App\Http\Controllers\Industry\TeamController::class, 'updateRole'])->name('team.updateRole');
        Route::delete('/team/{id}', [App\Http\Controllers\Industry\TeamController::class, 'remove'])->name('team.remove');
    });

    // =====================
    // EDUCATION ROUTES
    // =====================
    Route::prefix('education')->name('education.')->group(function () {
        Route::get('/dashboard', [EducationDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', function () {
            return view('education.analytics');
        })->name('analytics');
        Route::get('/students', [\App\Http\Controllers\Education\StudentController::class, 'index'])->name('students');


        // ⭐ Partners & Collaboration Routes ⭐
        Route::get('/partners', [\App\Http\Controllers\Education\PartnersController::class, 'index'])->name('partners');
        Route::get('/partners/{id}', [\App\Http\Controllers\Education\PartnersController::class, 'show'])->name('partners.show');
        Route::get('/collaboration/create', [\App\Http\Controllers\Education\CollaborationController::class, 'create'])->name('collaboration.create');
        Route::post('/collaboration', [\App\Http\Controllers\Education\CollaborationController::class, 'store'])->name('collaboration.store');
        Route::get('/collaboration/success', [\App\Http\Controllers\Education\CollaborationController::class, 'success'])->name('collaboration.success');
        Route::get('/collaboration/history', [\App\Http\Controllers\Education\CollaborationController::class, 'history'])->name('collaboration.history');
    });







    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/extract-ijazah', [ProfileController::class, 'extractIjazahData'])->name('profile.extract.ijazah');

    // Notifications
    Route::put('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');



    // Admin Routes (Update yang sebelumnya)
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');







        // Users (Manual Routes agar nama route simpel: admin.users)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Competencies (Manual Routes)
        Route::get('/competencies', [\App\Http\Controllers\Admin\CompetencyController::class, 'index'])->name('competencies');
        Route::get('/competencies/create', [\App\Http\Controllers\Admin\CompetencyController::class, 'create'])->name('competencies.create');
        Route::post('/competencies', [\App\Http\Controllers\Admin\CompetencyController::class, 'store'])->name('competencies.store');
        Route::get('/competencies/{competency}/edit', [\App\Http\Controllers\Admin\CompetencyController::class, 'edit'])->name('competencies.edit');
        Route::put('/competencies/{competency}', [\App\Http\Controllers\Admin\CompetencyController::class, 'update'])->name('competencies.update');
        Route::delete('/competencies/{competency}', [\App\Http\Controllers\Admin\CompetencyController::class, 'destroy'])->name('competencies.destroy');

        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Positions
        Route::resource('positions', \App\Http\Controllers\Admin\PositionController::class);

        // Courses
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

        // Skill Keywords
        Route::resource('skill-keywords', \App\Http\Controllers\Admin\SkillKeywordController::class);

        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\DashboardController::class, 'reports'])->name('reports');
        Route::get('/reports/send-email', [\App\Http\Controllers\Admin\DashboardController::class, 'sendEmail'])->name('reports.send_email');

        // Document Weights
        Route::resource('document-weights', \App\Http\Controllers\Admin\DocumentWeightController::class);

        // AI Workflow & Diagnostics
        Route::get('/ai-workflow', [\App\Http\Controllers\Admin\DashboardController::class, 'aiWorkflow'])->name('ai-workflow');
        Route::post('/ai-workflow/diagnostic', [\App\Http\Controllers\Admin\DashboardController::class, 'runDiagnostic'])->name('ai-workflow.diagnostic');
        Route::get('/ai-workflow/user-documents/{userId}', [\App\Http\Controllers\Admin\DashboardController::class, 'getUserDocuments'])->name('ai-workflow.user-documents');
        Route::get('/ai-workflow/extract-text/{documentId}', [\App\Http\Controllers\Admin\DashboardController::class, 'extractDocumentText'])->name('ai-workflow.extract-text');
    });



    // =====================
    // COMMON ROUTES
    // =====================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::put('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
});

// Google Auth
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

require __DIR__ . '/auth.php';
