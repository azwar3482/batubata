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
use App\Http\Controllers\Industry\JobPostingController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// Nanti: Route::post('/roadmap/{id}/complete', ...);

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Legal Pages
Route::get('/kebijakan-privasi', function () {
    return view('legal.privacy-policy');
})->name('legal.privacy');
Route::get('/syarat-ketentuan', function () {
    return view('legal.terms');
})->name('legal.terms');

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












// Route yang butuh Auth & Redirect Role
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Umum (Akan di-redirect oleh middleware sesuai role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Certificate Route
    Route::get('/certificates/class/{enrollment}', [CourseController::class, 'viewCertificate'])->name('courses.certificate');
    Route::get('/certificates/class/{enrollment}/pdf', [CourseController::class, 'downloadCertificatePdf'])->name('courses.certificate.pdf');
    Route::get('/certificates/platform/{progress}', [CourseController::class, 'viewPlatformCertificate'])->name('courses.platform-certificate');
    Route::get('/certificates/platform/{progress}/pdf', [CourseController::class, 'downloadPlatformCertificatePdf'])->name('courses.platform-certificate.pdf');


    // Tambahkan di dalam group auth
    Route::post('/profile/cv-upload', [ProfileController::class, 'uploadCv'])->middleware('throttle:10,1')->name('profile.cv.upload');
    Route::post('/profile/photo-upload', [ProfileController::class, 'uploadPhoto'])->middleware('throttle:10,1')->name('profile.photo.upload');
    Route::post('/profile/documents-upload', [ProfileController::class, 'uploadDocuments'])->middleware('throttle:10,1')->name('profile.documents.upload');
    Route::delete('/profile/documents/{id}', [ProfileController::class, 'deleteDocument'])->name('profile.documents.destroy');
    Route::post('/profile/update-location', [ProfileController::class, 'updateLocation'])->middleware('throttle:30,1')->name('profile.location.update');
    Route::patch('/profile/mobile-layout', [ProfileController::class, 'updateMobileLayout'])->name('profile.mobile-layout.update');
    Route::post('/profile/custom-document', [ProfileController::class, 'uploadCustomDocument'])->name('profile.custom-document.upload');
    Route::delete('/profile/custom-document/{id}', [ProfileController::class, 'deleteCustomDocument'])->name('profile.custom-document.delete');

    // =====================
    // JOB SEEKER ROUTES
    // =====================
    Route::prefix('seeker')->name('seeker.')->middleware('role:job_seeker')->group(function () {

        // routes/web.php - inside seeker group

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
        Route::get('/assessment/from-job/{jobId}', [AssessmentController::class, 'fromJob'])->name('assessment.from-job');
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
        Route::post('/jobs/{id}/apply', [DashboardController::class, 'applyJob'])->middleware('profile.complete')->name('jobs.apply');
        Route::post('/jobs/{id}/save', [DashboardController::class, 'saveJob'])->name('jobs.save');
        Route::delete('/jobs/{id}/withdraw', [DashboardController::class, 'withdrawApplication'])->name('jobs.withdraw');
        Route::post('/jobs/{id}/offer-response', [DashboardController::class, 'respondToOffer'])->name('jobs.offer-response');
        // Courses
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/my-progress', [CourseController::class, 'myProgress'])->name('courses.my-progress');
        Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{id}/learn', [CourseController::class, 'learn'])->name('courses.learn');
        Route::get('/courses/{courseId}/materials/{materialId}', [CourseController::class, 'learnMaterial'])->name('courses.learn-material');
        Route::get('/courses/{courseId}/materials/{materialId}/view', [CourseController::class, 'viewMaterial'])->name('courses.view-material');
        Route::get('/courses/{courseId}/materials/{materialId}/download', [CourseController::class, 'downloadMaterial'])->name('courses.download-material');
        Route::post('/courses/{courseId}/materials/{materialId}/complete', [CourseController::class, 'completeMaterial'])->name('courses.complete-material');
        Route::post('/courses/{courseId}/materials/{materialId}/quiz', [CourseController::class, 'submitQuiz'])->name('courses.submit-quiz');
        Route::post('/courses/{courseId}/materials/{materialId}/assignment', [CourseController::class, 'submitAssignment'])->name('courses.submit-assignment');
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
        Route::put('/courses/{id}/progress', [CourseController::class, 'updateProgress'])->name('courses.update-progress');
        Route::post('/courses/{id}/complete', [CourseController::class, 'complete'])->name('courses.complete');

        // Reports
        Route::get('/reports/assessment/{id}/pdf', [ReportController::class, 'downloadAssessment'])->name('reports.assessment.pdf');

        // CV Preview & Download
        Route::get('/cv/preview', [App\Http\Controllers\CvController::class, 'preview'])->name('cv.preview');
        Route::get('/cv/download', [App\Http\Controllers\CvController::class, 'download'])->name('cv.download');

        // Career Fields / Roadmap Jurusan
        Route::get('/career-fields', [App\Http\Controllers\CareerFieldController::class, 'index'])->name('career-fields.index');
        Route::get('/career-fields/{slug}', [App\Http\Controllers\CareerFieldController::class, 'show'])->name('career-fields.show');

        // TPA (Tes Potensi Akademik)
        Route::get('/tpa', [App\Http\Controllers\SeekerTpaController::class, 'index'])->name('tpa.index');
        Route::get('/tpa/{session}', [App\Http\Controllers\SeekerTpaController::class, 'show'])->name('tpa.show');
        Route::post('/tpa/{session}/start', [App\Http\Controllers\SeekerTpaController::class, 'start'])->name('tpa.start');
        Route::get('/tpa/{session}/test', [App\Http\Controllers\SeekerTpaController::class, 'test'])->name('tpa.test');
        Route::post('/tpa/{session}/answer', [App\Http\Controllers\SeekerTpaController::class, 'saveAnswer'])->name('tpa.save-answer');
        Route::post('/tpa/{session}/submit', [App\Http\Controllers\SeekerTpaController::class, 'submit'])->name('tpa.submit');
        Route::get('/tpa/{session}/result', [App\Http\Controllers\SeekerTpaController::class, 'result'])->name('tpa.result');
        Route::get('/tpa/{session}/result/pdf', [App\Http\Controllers\SeekerTpaController::class, 'downloadPdf'])->name('tpa.result.pdf');
        Route::post('/tpa/{session}/respond-offline', [App\Http\Controllers\SeekerTpaController::class, 'respondOffline'])->name('tpa.respond-offline');

        // Direct Chats (Seeker)
        Route::get('/chats/{id?}', [App\Http\Controllers\DirectChatController::class, 'seekerIndex'])->name('chats.index');
        Route::post('/chats/{conversation}/send', [App\Http\Controllers\DirectChatController::class, 'sendMessage'])->name('chats.send');
    });

    // =====================
    // INDUSTRY ROUTES
    // =====================
    Route::prefix('industry')->name('industry.')->middleware('role:industry,staf_hr_manager,staf_recruiter,staf_talent_sourcer,staf_interviewer')->group(function () {
        Route::get('/dashboard', [IndustryDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/report', [IndustryDashboardController::class, 'downloadReport'])->name('dashboard.report');
        Route::get('/jobs', [JobPostingController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [JobPostingController::class, 'create'])->name('jobs.create');
        Route::post('/jobs/store', [JobPostingController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{id}', [JobPostingController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{id}/edit', [JobPostingController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{id}', [JobPostingController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobPostingController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{id}/report', [JobPostingController::class, 'downloadReport'])->name('jobs.report');
        Route::get('/candidates', [App\Http\Controllers\Industry\CandidateController::class, 'index'])->name('candidates');
        Route::get('/candidates/{id}', [App\Http\Controllers\Industry\CandidateController::class, 'show'])->name('candidates.show');
        Route::put('/applications/{id}/status', [App\Http\Controllers\Industry\CandidateController::class, 'updateStatus'])->name('applications.update-status');
        Route::put('/applications/{id}/notes', [App\Http\Controllers\Industry\CandidateController::class, 'updateNotes'])->name('applications.update-notes');
        Route::post('/applications/{id}/invite-tpa', [App\Http\Controllers\Industry\CandidateController::class, 'inviteTpa'])->name('applications.invite-tpa');
        Route::get('/jobs/{id}/talent', [JobPostingController::class, 'findTalent'])->name('jobs.talent');
        Route::post('/jobs/{id}/offer/{userId}', [JobPostingController::class, 'offerJob'])->name('jobs.offer');
        Route::get('/guide', function () {
            return view('industry.guide');
        })->name('guide');

        // Team Management
        Route::get('/team', [App\Http\Controllers\Industry\TeamController::class, 'index'])->name('team');
        Route::post('/team/invite', [App\Http\Controllers\Industry\TeamController::class, 'invite'])->name('team.invite');
        Route::put('/team/{id}/role', [App\Http\Controllers\Industry\TeamController::class, 'updateRole'])->name('team.updateRole');
        Route::delete('/team/{id}', [App\Http\Controllers\Industry\TeamController::class, 'remove'])->name('team.remove');

        // TPA Management
        Route::get('/tpa', [App\Http\Controllers\Industry\TpaController::class, 'index'])->name('tpa.index');
        Route::get('/tpa/create', [App\Http\Controllers\Industry\TpaController::class, 'create'])->name('tpa.create');
        Route::post('/tpa', [App\Http\Controllers\Industry\TpaController::class, 'store'])->name('tpa.store');
        Route::get('/tpa/{test}/edit', [App\Http\Controllers\Industry\TpaController::class, 'edit'])->name('tpa.edit');
        Route::put('/tpa/{test}', [App\Http\Controllers\Industry\TpaController::class, 'update'])->name('tpa.update');
        Route::delete('/tpa/{test}', [App\Http\Controllers\Industry\TpaController::class, 'destroy'])->name('tpa.destroy');
        Route::post('/tpa/{test}/invite', [App\Http\Controllers\Industry\TpaController::class, 'inviteCandidate'])->name('tpa.invite');
        Route::post('/tpa/bulk-invite', [App\Http\Controllers\Industry\TpaController::class, 'bulkInvite'])->name('tpa.bulk-invite');
        Route::post('/tpa/bulk-invite-offline', [App\Http\Controllers\Industry\TpaController::class, 'bulkInviteOffline'])->name('tpa.bulk-invite-offline');
        Route::post('/tpa/sessions/{session}/offline-result', [App\Http\Controllers\Industry\TpaController::class, 'submitOfflineResult'])->name('tpa.offline-result');
        Route::get('/tpa/results', [App\Http\Controllers\Industry\TpaController::class, 'results'])->name('tpa.results');
        Route::get('/tpa/results/{result}', [App\Http\Controllers\Industry\TpaController::class, 'showResult'])->name('tpa.results.show');
        Route::get('/tpa/results/{result}/pdf', [App\Http\Controllers\Industry\TpaController::class, 'downloadPdf'])->name('tpa.results.pdf');

        // TPA Bank Soal (Industry)
        Route::get('/tpa/questions', [App\Http\Controllers\Industry\TpaController::class, 'questions'])->name('tpa.questions');
        Route::get('/tpa/questions/create', [App\Http\Controllers\Industry\TpaController::class, 'createQuestion'])->name('tpa.questions.create');
        Route::post('/tpa/questions', [App\Http\Controllers\Industry\TpaController::class, 'storeQuestion'])->name('tpa.questions.store');
        Route::get('/tpa/questions/{question}/edit', [App\Http\Controllers\Industry\TpaController::class, 'editQuestion'])->name('tpa.questions.edit');
        Route::put('/tpa/questions/{question}', [App\Http\Controllers\Industry\TpaController::class, 'updateQuestion'])->name('tpa.questions.update');
        Route::delete('/tpa/questions/{question}', [App\Http\Controllers\Industry\TpaController::class, 'destroyQuestion'])->name('tpa.questions.destroy');
        Route::get('/tpa/questions/download-template', [App\Http\Controllers\Industry\TpaController::class, 'downloadTemplate'])->name('tpa.questions.download-template');
        Route::post('/tpa/questions/import', [App\Http\Controllers\Industry\TpaController::class, 'importQuestions'])->name('tpa.questions.import');

        // Direct Chats (Industry)
        Route::post('/chats/initiate', [App\Http\Controllers\DirectChatController::class, 'initiate'])->name('chats.initiate');
        Route::get('/chats/{id?}', [App\Http\Controllers\DirectChatController::class, 'industryIndex'])->name('chats.index');
        Route::post('/chats/{conversation}/send', [App\Http\Controllers\DirectChatController::class, 'sendMessage'])->name('chats.send');

        // Competency Management (Industry)
        Route::get('/competencies', [App\Http\Controllers\Industry\CompetencyController::class, 'index'])->name('competencies.index');
        Route::get('/competencies/create', [App\Http\Controllers\Industry\CompetencyController::class, 'create'])->name('competencies.create');
        Route::post('/competencies', [App\Http\Controllers\Industry\CompetencyController::class, 'store'])->name('competencies.store');
        Route::get('/competencies/{competency}/edit', [App\Http\Controllers\Industry\CompetencyController::class, 'edit'])->name('competencies.edit');
        Route::put('/competencies/{competency}', [App\Http\Controllers\Industry\CompetencyController::class, 'update'])->name('competencies.update');
        Route::delete('/competencies/{competency}', [App\Http\Controllers\Industry\CompetencyController::class, 'destroy'])->name('competencies.destroy');
    });

    // =====================
    // TEACHER ROUTES
    // =====================
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

        // Course Management
        Route::get('/courses', [\App\Http\Controllers\Teacher\CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [\App\Http\Controllers\Teacher\CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [\App\Http\Controllers\Teacher\CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}', [\App\Http\Controllers\Teacher\CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [\App\Http\Controllers\Teacher\CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [\App\Http\Controllers\Teacher\CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [\App\Http\Controllers\Teacher\CourseController::class, 'destroy'])->name('courses.destroy');
        Route::post('/courses/{course}/publish', [\App\Http\Controllers\Teacher\CourseController::class, 'publish'])->name('courses.publish');
        Route::post('/courses/{course}/unpublish', [\App\Http\Controllers\Teacher\CourseController::class, 'unpublish'])->name('courses.unpublish');

        // Module Management
        Route::post('/courses/{course}/modules', [\App\Http\Controllers\Teacher\CourseController::class, 'storeModule'])->name('courses.store-module');
        Route::put('/modules/{module}', [\App\Http\Controllers\Teacher\CourseController::class, 'updateModule'])->name('courses.update-module');
        Route::delete('/modules/{module}', [\App\Http\Controllers\Teacher\CourseController::class, 'destroyModule'])->name('courses.destroy-module');

        // Material Management
        Route::post('/modules/{module}/materials', [\App\Http\Controllers\Teacher\CourseController::class, 'storeMaterial'])->name('courses.store-material');
        Route::put('/materials/{material}', [\App\Http\Controllers\Teacher\CourseController::class, 'updateMaterial'])->name('courses.update-material');
        Route::delete('/materials/{material}', [\App\Http\Controllers\Teacher\CourseController::class, 'destroyMaterial'])->name('courses.destroy-material');
        Route::get('/materials/{material}/download', [\App\Http\Controllers\Teacher\CourseController::class, 'downloadMaterial'])->name('courses.download-material');

        // Class Management
        Route::get('/classes', [\App\Http\Controllers\Teacher\ClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/create', [\App\Http\Controllers\Teacher\ClassController::class, 'create'])->name('classes.create');
        Route::post('/classes', [\App\Http\Controllers\Teacher\ClassController::class, 'store'])->name('classes.store');
        Route::get('/classes/{class}', [\App\Http\Controllers\Teacher\ClassController::class, 'show'])->name('classes.show');
        Route::get('/classes/{class}/edit', [\App\Http\Controllers\Teacher\ClassController::class, 'edit'])->name('classes.edit');
        Route::put('/classes/{class}', [\App\Http\Controllers\Teacher\ClassController::class, 'update'])->name('classes.update');
        Route::delete('/classes/{class}', [\App\Http\Controllers\Teacher\ClassController::class, 'destroy'])->name('classes.destroy');
        Route::post('/classes/{class}/enroll', [\App\Http\Controllers\Teacher\ClassController::class, 'enrollStudent'])->name('classes.enroll-student');
        Route::put('/enrollments/{enrollment}/status', [\App\Http\Controllers\Teacher\ClassController::class, 'updateStudentStatus'])->name('classes.update-student');
        Route::delete('/enrollments/{enrollment}', [\App\Http\Controllers\Teacher\ClassController::class, 'removeStudent'])->name('classes.remove-student');

        // Submissions
        Route::get('/submissions', [\App\Http\Controllers\Teacher\SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [\App\Http\Controllers\Teacher\SubmissionController::class, 'show'])->name('submissions.show');
        Route::post('/submissions/{submission}/grade', [\App\Http\Controllers\Teacher\SubmissionController::class, 'grade'])->name('submissions.grade');
    });

    // =====================
    // EDUCATION ROUTES
    // =====================
    Route::prefix('education')->name('education.')->middleware('role:education')->group(function () {
        Route::get('/dashboard', [EducationDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', function () {
            return view('education.analytics');
        })->name('analytics');
        Route::get('/analytics/export/excel', [\App\Http\Controllers\Education\AnalyticsController::class, 'exportExcel'])->name('analytics.export.excel');
        Route::get('/analytics/export/pdf', [\App\Http\Controllers\Education\AnalyticsController::class, 'exportPdf'])->name('analytics.export.pdf');
        Route::get('/students', [\App\Http\Controllers\Education\StudentController::class, 'index'])->name('students');
        Route::get('/students/{student}', [\App\Http\Controllers\Education\StudentController::class, 'show'])->name('students.show');

        // Course Management (Education role - using teacher_courses table)
        Route::get('/courses', [\App\Http\Controllers\Education\CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [\App\Http\Controllers\Education\CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [\App\Http\Controllers\Education\CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}', [\App\Http\Controllers\Education\CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [\App\Http\Controllers\Education\CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [\App\Http\Controllers\Education\CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [\App\Http\Controllers\Education\CourseController::class, 'destroy'])->name('courses.destroy');
        Route::post('/courses/{course}/publish', [\App\Http\Controllers\Education\CourseController::class, 'publish'])->name('courses.publish');
        Route::post('/courses/{course}/unpublish', [\App\Http\Controllers\Education\CourseController::class, 'unpublish'])->name('courses.unpublish');

        // Program Management (Education role)
        Route::get('/programs', [App\Http\Controllers\Education\ProgramController::class, 'index'])->name('programs');
        Route::get('/programs/create', [App\Http\Controllers\Education\ProgramController::class, 'create'])->name('programs.create');
        Route::post('/programs', [App\Http\Controllers\Education\ProgramController::class, 'store'])->name('programs.store');
        Route::get('/programs/{program}/edit', [App\Http\Controllers\Education\ProgramController::class, 'edit'])->name('programs.edit');
        Route::put('/programs/{program}', [App\Http\Controllers\Education\ProgramController::class, 'update'])->name('programs.update');
        Route::delete('/programs/{program}', [App\Http\Controllers\Education\ProgramController::class, 'destroy'])->name('programs.destroy');
        Route::get('/programs/{program}/report', [App\Http\Controllers\Education\ProgramController::class, 'report'])->name('programs.report');

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




    // Admin Routes (Update yang sebelumnya)
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:access-admin', 'role:admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Settings & Competency Management
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/competency/{id}', [\App\Http\Controllers\Admin\SettingsController::class, 'updateCompetency'])->name('settings.competency.update');
        Route::post('/settings/system', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSystemSettings'])->name('settings.system');
        Route::post('/settings/sync', [\App\Http\Controllers\Admin\SettingsController::class, 'syncCompetencies'])->name('settings.sync');

        // Users (Manual Routes agar nama route simpel: admin.users)



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

        // Course Chapter Management
        Route::post('/courses/{course}/chapters', [\App\Http\Controllers\Admin\CourseController::class, 'storeChapter'])->name('courses.store-chapter');
        Route::put('/chapters/{chapter}', [\App\Http\Controllers\Admin\CourseController::class, 'updateChapter'])->name('courses.update-chapter');
        Route::delete('/chapters/{chapter}', [\App\Http\Controllers\Admin\CourseController::class, 'destroyChapter'])->name('courses.destroy-chapter');

        // Course Material Management
        Route::post('/chapters/{chapter}/materials', [\App\Http\Controllers\Admin\CourseController::class, 'storeMaterial'])->name('courses.store-material');
        Route::put('/materials/{material}', [\App\Http\Controllers\Admin\CourseController::class, 'updateMaterial'])->name('courses.update-material');
        Route::delete('/materials/{material}', [\App\Http\Controllers\Admin\CourseController::class, 'destroyMaterial'])->name('courses.destroy-material');
        Route::get('/materials/{material}/download', [\App\Http\Controllers\Admin\CourseController::class, 'downloadMaterial'])->name('courses.download-material');

        // Quiz Question Management
        Route::post('/materials/{material}/questions', [\App\Http\Controllers\Admin\CourseController::class, 'storeQuizQuestion'])->name('courses.store-question');
        Route::put('/questions/{question}', [\App\Http\Controllers\Admin\CourseController::class, 'updateQuizQuestion'])->name('courses.update-question');
        Route::delete('/questions/{question}', [\App\Http\Controllers\Admin\CourseController::class, 'destroyQuizQuestion'])->name('courses.destroy-question');

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

        // Chat FAQ Management
        Route::resource('chat-faqs', \App\Http\Controllers\Admin\ChatFaqController::class);

        // Career Fields Management
        Route::resource('career-fields', \App\Http\Controllers\Admin\CareerFieldController::class);
        Route::get('/career-fields/{careerField}/paths', [\App\Http\Controllers\Admin\CareerFieldController::class, 'paths'])->name('career-fields.paths');
        Route::get('/career-fields/{careerField}/paths/create', [\App\Http\Controllers\Admin\CareerFieldController::class, 'createPath'])->name('career-fields.create-path');
        Route::post('/career-fields/{careerField}/paths', [\App\Http\Controllers\Admin\CareerFieldController::class, 'storePath'])->name('career-fields.store-path');
        Route::get('/career-fields/{careerField}/paths/{path}/edit', [\App\Http\Controllers\Admin\CareerFieldController::class, 'editPath'])->name('career-fields.edit-path');
        Route::put('/career-fields/{careerField}/paths/{path}', [\App\Http\Controllers\Admin\CareerFieldController::class, 'updatePath'])->name('career-fields.update-path');
        Route::delete('/career-fields/{careerField}/paths/{path}', [\App\Http\Controllers\Admin\CareerFieldController::class, 'destroyPath'])->name('career-fields.destroy-path');

        // TPA Management
        Route::get('/tpa', [\App\Http\Controllers\Admin\TpaController::class, 'dashboard'])->name('tpa.dashboard');
        Route::get('/tpa/questions', [\App\Http\Controllers\Admin\TpaController::class, 'questions'])->name('tpa.questions');
        Route::get('/tpa/questions/create', [\App\Http\Controllers\Admin\TpaController::class, 'createQuestion'])->name('tpa.questions.create');
        Route::post('/tpa/questions', [\App\Http\Controllers\Admin\TpaController::class, 'storeQuestion'])->name('tpa.questions.store');
        Route::get('/tpa/questions/{question}/edit', [\App\Http\Controllers\Admin\TpaController::class, 'editQuestion'])->name('tpa.questions.edit');
        Route::put('/tpa/questions/{question}', [\App\Http\Controllers\Admin\TpaController::class, 'updateQuestion'])->name('tpa.questions.update');
        Route::delete('/tpa/questions/{question}', [\App\Http\Controllers\Admin\TpaController::class, 'destroyQuestion'])->name('tpa.questions.destroy');
        Route::get('/tpa/tests', [\App\Http\Controllers\Admin\TpaController::class, 'tests'])->name('tpa.tests');
        Route::get('/tpa/tests/create', [\App\Http\Controllers\Admin\TpaController::class, 'createTest'])->name('tpa.tests.create');
        Route::post('/tpa/tests', [\App\Http\Controllers\Admin\TpaController::class, 'storeTest'])->name('tpa.tests.store');
        Route::get('/tpa/tests/{test}/edit', [\App\Http\Controllers\Admin\TpaController::class, 'editTest'])->name('tpa.tests.edit');
        Route::put('/tpa/tests/{test}', [\App\Http\Controllers\Admin\TpaController::class, 'updateTest'])->name('tpa.tests.update');
        Route::delete('/tpa/tests/{test}', [\App\Http\Controllers\Admin\TpaController::class, 'destroyTest'])->name('tpa.tests.destroy');
        Route::get('/tpa/results', [\App\Http\Controllers\Admin\TpaController::class, 'results'])->name('tpa.results');
        Route::get('/tpa/results/{result}', [\App\Http\Controllers\Admin\TpaController::class, 'showResult'])->name('tpa.results.show');
        Route::get('/tpa/results/{result}/pdf', [\App\Http\Controllers\Admin\TpaController::class, 'downloadPdf'])->name('tpa.results.pdf');
    });



    // =====================
    // COMMON ROUTES
    // =====================

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::put('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Chat Agent (rate limited)
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('send')->middleware('throttle:20,1');
        Route::get('/history', [App\Http\Controllers\ChatController::class, 'history'])->name('history')->middleware('throttle:60,1');
        Route::get('/sessions', [App\Http\Controllers\ChatController::class, 'sessions'])->name('sessions')->middleware('throttle:30,1');
        Route::delete('/history', [App\Http\Controllers\ChatController::class, 'clearHistory'])->name('clear')->middleware('throttle:10,1');
        Route::get('/suggestions', [App\Http\Controllers\ChatController::class, 'suggestions'])->name('suggestions')->middleware('throttle:60,1');
        Route::get('/status', [App\Http\Controllers\ChatController::class, 'status'])->name('status')->middleware('throttle:60,1');
    });
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
