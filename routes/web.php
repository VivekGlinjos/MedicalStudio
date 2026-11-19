<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SuccessStoriesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\SeatPredictorController;
use App\Http\Controllers\InstitutesController;
use App\Http\Controllers\CounsellingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ChoiceListController;
use App\Http\Controllers\PaymentController;

// =============================================================
// ADMIN ROUTES
// =============================================================
Route::prefix('admin')->group(function () {

    // Admin Auth (no middleware)
    Route::get('/login',  [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.post');

    // Admin Protected Routes
    Route::middleware(['admin'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');

        // Colleges
        Route::get('/colleges',                 [\App\Http\Controllers\Admin\CollegeController::class, 'index'])->name('admin.colleges.index');
        Route::get('/colleges/create',          [\App\Http\Controllers\Admin\CollegeController::class, 'create'])->name('admin.colleges.create');
        Route::post('/colleges',                [\App\Http\Controllers\Admin\CollegeController::class, 'store'])->name('admin.colleges.store');
        Route::get('/colleges/{id}/edit',       [\App\Http\Controllers\Admin\CollegeController::class, 'edit'])->name('admin.colleges.edit');
        Route::put('/colleges/{id}',            [\App\Http\Controllers\Admin\CollegeController::class, 'update'])->name('admin.colleges.update');
        Route::delete('/colleges/{id}',         [\App\Http\Controllers\Admin\CollegeController::class, 'destroy'])->name('admin.colleges.destroy');
        Route::post('/colleges/{id}/toggle',    [\App\Http\Controllers\Admin\CollegeController::class, 'toggleStatus'])->name('admin.colleges.toggle');

        // Past Allotments (Cutoffs)
        Route::get('cutoffs/fetch-managed', [\App\Http\Controllers\Admin\CutoffController::class, 'fetchManaged'])->name('admin.cutoffs.fetch-managed');
        Route::get('cutoffs/manage', [\App\Http\Controllers\Admin\CutoffController::class, 'manage'])->name('admin.cutoffs.manage');
        Route::post('cutoffs/manage', [\App\Http\Controllers\Admin\CutoffController::class, 'storeManaged'])->name('admin.cutoffs.store-managed');
        Route::resource('cutoffs', \App\Http\Controllers\Admin\CutoffController::class, ['as' => 'admin'])->except(['show']);



        // Courses
        Route::get('/courses',                  [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.courses.index');
        Route::get('/courses/create',           [\App\Http\Controllers\Admin\CourseController::class, 'create'])->name('admin.courses.create');
        Route::post('/courses',                 [\App\Http\Controllers\Admin\CourseController::class, 'store'])->name('admin.courses.store');

        // Galleries
        Route::get('/galleries', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('admin.galleries.index');
        Route::get('/galleries/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('admin.galleries.show');
        Route::post('/galleries/{college_id}', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('admin.galleries.store');
        Route::delete('/galleries/image/{id}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('admin.galleries.destroy');

        Route::get('/courses/{id}/edit',        [\App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('admin.courses.edit');
        Route::put('/courses/{id}',             [\App\Http\Controllers\Admin\CourseController::class, 'update'])->name('admin.courses.update');
        Route::delete('/courses/{id}',          [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('admin.courses.destroy');
        Route::post('/courses/{id}/toggle',     [\App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])->name('admin.courses.toggle');

        // States
        Route::get('/states',                   [\App\Http\Controllers\Admin\StateController::class, 'index'])->name('admin.states.index');
        Route::get('/states/create',            [\App\Http\Controllers\Admin\StateController::class, 'create'])->name('admin.states.create');
        Route::post('/states',                  [\App\Http\Controllers\Admin\StateController::class, 'store'])->name('admin.states.store');
        Route::get('/states/{id}/edit',         [\App\Http\Controllers\Admin\StateController::class, 'edit'])->name('admin.states.edit');
        Route::put('/states/{id}',              [\App\Http\Controllers\Admin\StateController::class, 'update'])->name('admin.states.update');
        Route::delete('/states/{id}',           [\App\Http\Controllers\Admin\StateController::class, 'destroy'])->name('admin.states.destroy');

        // Blogs
        Route::get('/blogs',                    [\App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blogs.index');
        Route::get('/blogs/create',             [\App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin.blogs.create');
        Route::post('/blogs',                   [\App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blogs.store');
        Route::get('/blogs/{id}/edit',          [\App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blogs.edit');
        Route::put('/blogs/{id}',               [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blogs.update');
        Route::delete('/blogs/{id}',            [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blogs.destroy');
        Route::post('/blogs/{id}/toggle',       [\App\Http\Controllers\Admin\BlogController::class, 'togglePublish'])->name('admin.blogs.toggle');

        // Service Packages
        Route::get('/packages',                 [\App\Http\Controllers\Admin\PackageController::class, 'index'])->name('admin.packages.index');
        Route::get('/packages/create',          [\App\Http\Controllers\Admin\PackageController::class, 'create'])->name('admin.packages.create');
        Route::post('/packages',                [\App\Http\Controllers\Admin\PackageController::class, 'store'])->name('admin.packages.store');
        Route::get('/packages/{id}/edit',       [\App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('admin.packages.edit');
        Route::put('/packages/{id}',            [\App\Http\Controllers\Admin\PackageController::class, 'update'])->name('admin.packages.update');
        Route::delete('/packages/{id}',         [\App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('admin.packages.destroy');
        Route::post('/packages/{id}/toggle',    [\App\Http\Controllers\Admin\PackageController::class, 'toggleStatus'])->name('admin.packages.toggle');

        // Enquiries
        Route::get('/enquiries',                [\App\Http\Controllers\Admin\EnquiryController::class, 'index'])->name('admin.enquiries.index');
        Route::get('/enquiries/{id}',           [\App\Http\Controllers\Admin\EnquiryController::class, 'show'])->name('admin.enquiries.show');
        Route::delete('/enquiries/{id}',        [\App\Http\Controllers\Admin\EnquiryController::class, 'destroy'])->name('admin.enquiries.destroy');

        // Media - Videos
        Route::get('/videos',                   [\App\Http\Controllers\Admin\MediaController::class, 'videosIndex'])->name('admin.media.videos');
        Route::get('/videos/create',            [\App\Http\Controllers\Admin\MediaController::class, 'videoCreate'])->name('admin.media.video.create');
        Route::post('/videos',                  [\App\Http\Controllers\Admin\MediaController::class, 'videoStore'])->name('admin.media.video.store');
        Route::get('/videos/{id}/edit',         [\App\Http\Controllers\Admin\MediaController::class, 'videoEdit'])->name('admin.media.video.edit');
        Route::put('/videos/{id}',              [\App\Http\Controllers\Admin\MediaController::class, 'videoUpdate'])->name('admin.media.video.update');
        Route::delete('/videos/{id}',           [\App\Http\Controllers\Admin\MediaController::class, 'videoDestroy'])->name('admin.media.video.destroy');

        // Media - Gallery
        Route::get('/gallery',                  [\App\Http\Controllers\Admin\MediaController::class, 'galleryIndex'])->name('admin.media.gallery');
        Route::get('/gallery/create',           [\App\Http\Controllers\Admin\MediaController::class, 'galleryCreate'])->name('admin.media.gallery.create');
        Route::post('/gallery',                 [\App\Http\Controllers\Admin\MediaController::class, 'galleryStore'])->name('admin.media.gallery.store');
        Route::delete('/gallery/{id}',          [\App\Http\Controllers\Admin\MediaController::class, 'galleryDestroy'])->name('admin.media.gallery.destroy');
    });
});

// =============================================================
// PUBLIC ROUTES
// =============================================================
Route::get('/',               [HomeController::class, 'index'])->name('home');
Route::get('/features',       [FeaturesController::class, 'index'])->name('features');
Route::get('/services',       [ServicesController::class, 'index'])->name('services');
Route::get('/success-stories',[SuccessStoriesController::class, 'index'])->name('success-stories');
Route::get('/about',          [AboutController::class, 'index'])->name('about');
Route::get('/contact',        [ContactController::class, 'index'])->name('contact');
Route::post('/contact',       [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/packages',       [PackagesController::class, 'index'])->name('packages');
// =============================================================
// =============================================================
// PUBLIC PORTAL ROUTES (Accessible without login)
// =============================================================
// Colleges – Frontend Colleges
Route::get('/colleges',       [CollegeController::class, 'index'])->name('colleges.index');
Route::get('/colleges/{slug}',[CollegeController::class, 'show'])->name('colleges.show');


// Courses & States
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/states',  [StateController::class, 'index'])->name('states.index');

// Blog routes
Route::get('/blog',           [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}',    [BlogController::class, 'show'])->name('blog.show');

// Institutes
Route::get('/institutes',     [InstitutesController::class, 'index'])->name('institutes');

// Counselling pages
Route::get('/counsellings/{type}', [CounsellingController::class, 'show'])
    ->name('counselling.show')
    ->where('type', 'neet-pg|neet-ug|neet-mds|inicet|dnb-pdcet|neet-ss');

// Seat Predictor
Route::get('/seat-predictor', [SeatPredictorController::class, 'index'])->name('seat-predictor');
Route::post('/seat-predictor/calculate', [SeatPredictorController::class, 'calculate'])->name('seat-predictor.calculate');


// =============================================================
// LEGAL PAGES
// =============================================================
Route::view('/privacy-policy', 'privacy-policy')->name('privacy-policy');
Route::view('/refund-policy', 'refund-policy')->name('refund-policy');
Route::view('/terms-and-conditions', 'terms-conditions')->name('terms-conditions');

// =============================================================
// AUTH (Breeze: /login, /register, /logout)
// =============================================================
require __DIR__.'/auth.php';

// =============================================================
// PAYMENT (auth required)
// =============================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/{id}',     [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/verify',   [PaymentController::class, 'verify'])->name('payment.verify');
    Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed',    [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/invoice/{id}', [PaymentController::class, 'downloadInvoice'])->name('payment.invoice');
});

// Webhook (no CSRF, no auth)
Route::post('/payment/webhook',  [PaymentController::class, 'webhook'])->name('payment.webhook');

// =============================================================
// USER DASHBOARD (auth + is_paid)
// =============================================================
Route::middleware(['auth', 'is_paid'])->group(function () {
    Route::get('/dashboard',              [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/rank-scan',    [DashboardController::class, 'rankScan'])->name('dashboard.rank-scan');
    Route::get('/dashboard/allotment',    [DashboardController::class, 'allotment'])->name('dashboard.allotment');
    Route::get('/dashboard/seat-matrix',  [DashboardController::class, 'seatMatrix'])->name('dashboard.seat-matrix');
    Route::get('/dashboard/choice-list',  [DashboardController::class, 'choiceList'])->name('dashboard.choice-list');
    Route::get('/dashboard/enquiries',    [DashboardController::class, 'myEnquiries'])->name('dashboard.enquiries');
    Route::get('/dashboard/profile',      [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile',      [DashboardController::class, 'profileUpdate'])->name('dashboard.profile.update');
    Route::get('/dashboard/past-allotments', [\App\Http\Controllers\PastAllotmentController::class, 'index'])->name('past-allotments.index');
});

// =============================================================
// CHOICE LIST API
// =============================================================
Route::middleware(['auth'])->prefix('api/choice-list')->group(function () {
    Route::get('/active',        [ChoiceListController::class, 'getActiveList']);
    Route::get('/search',        [ChoiceListController::class, 'search']);
    Route::post('/store',        [ChoiceListController::class, 'store']);
    Route::post('/update-order', [ChoiceListController::class, 'updateOrder']);
    Route::delete('/{id}',       [ChoiceListController::class, 'destroy']);
});
