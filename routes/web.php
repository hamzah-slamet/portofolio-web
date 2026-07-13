<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioConfigController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\CertificateController;

// =====================
// PUBLIC
// =====================
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');

// Opsional: multi-user dengan username
Route::get('/portfolio/{username}', [PortfolioController::class, 'show'])->name('portfolio.user');
// =====================
// DASHBOARD GROUP
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan tampilan portfolio (hero, about, stats, contact, toggle section)
    Route::get('/settings',  [PortfolioConfigController::class, 'edit'])->name('settings.edit');
    Route::put('/settings',  [PortfolioConfigController::class, 'update'])->name('settings.update');

    // Menu navbar dinamis
    Route::get('/menus',            [MenuItemController::class, 'index'])->name('menus.index');
    Route::post('/menus',           [MenuItemController::class, 'store'])->name('menus.store');
    Route::put('/menus',            [MenuItemController::class, 'bulkUpdate'])->name('menus.bulk-update');
    Route::delete('/menus/{menu}',  [MenuItemController::class, 'destroy'])->name('menus.destroy');
});

// =====================
// PROJECTS GROUP
// =====================
Route::middleware(['auth', 'verified'])->group(function () {

    // Projects
    Route::get('/projects',                [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create',         [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects',               [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}',      [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}',   [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::patch('/projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');


    // Skills
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

    // Experiences
    Route::get('/experiences',                    [ExperienceController::class, 'index'])  ->name('experiences.index');
    Route::get('/experiences/create',             [ExperienceController::class, 'create']) ->name('experiences.create');
    Route::post('/experiences',                   [ExperienceController::class, 'store'])  ->name('experiences.store');
    Route::get('/experiences/{experience}/edit',  [ExperienceController::class, 'edit'])   ->name('experiences.edit');
    Route::put('/experiences/{experience}',       [ExperienceController::class, 'update']) ->name('experiences.update');
    Route::delete('/experiences/{experience}',    [ExperienceController::class, 'destroy'])->name('experiences.destroy');

    // Sertifikat
    Route::get('/certificates',                  [CertificateController::class, 'index'])  ->name('certificates.index');
    Route::post('/certificates',                 [CertificateController::class, 'store'])  ->name('certificates.store');
    Route::put('/certificates/{certificate}',    [CertificateController::class, 'update']) ->name('certificates.update');
    Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    Route::get('/educations',                   [EducationController::class, 'index'])  ->name('educations.index');
    Route::get('/educations/create',            [EducationController::class, 'create']) ->name('educations.create');
    Route::post('/educations',                  [EducationController::class, 'store'])  ->name('educations.store');
    Route::get('/educations/{education}/edit',  [EducationController::class, 'edit'])   ->name('educations.edit');
    Route::put('/educations/{education}',       [EducationController::class, 'update']) ->name('educations.update');
    Route::delete('/educations/{education}',    [EducationController::class, 'destroy'])->name('educations.destroy');

});

// =====================
// PROFILE GROUP
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});



Route::middleware('auth')->group(function () {
    Route::get('/cv', [CvController::class, 'index'])->name('cv.index');
    Route::get('/cv/download', [CvController::class, 'download'])->name('cv.download');
});

// ====================
Route::get('/register', fn() => redirect()->route('login'))->name('register');
Route::post('/register', fn() => redirect()->route('login'));

require __DIR__.'/auth.php';
