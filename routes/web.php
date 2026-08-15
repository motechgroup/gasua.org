<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Public\HomePage;
use App\Livewire\Public\AboutUs;
use App\Livewire\Public\ProgramsIndex;
use App\Livewire\Public\TalentDirectory;
use App\Livewire\Public\EventsIndex;
use App\Livewire\Public\CampaignsIndex;
use App\Livewire\Public\CampaignDetail;
use App\Livewire\Public\DonationCheckout;
use App\Livewire\Public\P2pCreate;
use App\Livewire\Public\P2pDetail;
use App\Livewire\Public\VolunteerRegister;
use App\Livewire\Public\NewsIndex;
use App\Livewire\Public\GalleryIndex;
use App\Livewire\Public\TransparencyDashboard;
use App\Livewire\Public\ContactUs;
use App\Livewire\Public\DonorDashboard;

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\CampaignManager;
use App\Livewire\Admin\DonationManager;
use App\Livewire\Admin\PaymentGatewaySettings;
use App\Livewire\Admin\PaymentLogsViewer;
use App\Livewire\Admin\VolunteerManager;
use App\Livewire\Admin\FinancialReports;
use App\Livewire\Admin\TransparencyManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Admin\CmsSettingsManager;

use App\Http\Controllers\Webhooks\MpesaWebhookController;
use App\Http\Controllers\Webhooks\FlutterwaveWebhookController;
use App\Http\Controllers\Webhooks\DpoWebhookController;
use App\Http\Controllers\Webhooks\PaypalWebhookController;
use App\Http\Controllers\Webhooks\NowpaymentsWebhookController;
use App\Http\Controllers\Webhooks\StripeWebhookController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SeoController;

/*
|--------------------------------------------------------------------------
| Public Foundation Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutUs::class)->name('public.about');
Route::get('/programs', ProgramsIndex::class)->name('public.programs');
Route::get('/talents', TalentDirectory::class)->name('public.talents');
Route::get('/events', EventsIndex::class)->name('public.events');
Route::get('/campaigns', CampaignsIndex::class)->name('public.campaigns');
Route::get('/campaigns/{slug}', CampaignDetail::class)->name('public.campaigns.show');

Route::middleware(['throttle:15,1'])->group(function () {
    Route::get('/donate', DonationCheckout::class)->name('public.donate');
    Route::get('/donate/checkout', DonationCheckout::class)->name('public.donate.checkout');
});

Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/fundraise/create', P2pCreate::class)->name('public.p2p.create');
    Route::get('/volunteer', VolunteerRegister::class)->name('public.volunteer');
    Route::get('/contact', ContactUs::class)->name('public.contact');
});

Route::get('/fundraise/{slug}', P2pDetail::class)->name('public.p2p.show');
Route::get('/news', NewsIndex::class)->name('public.news');
Route::get('/gallery', GalleryIndex::class)->name('public.gallery');
Route::get('/transparency', TransparencyDashboard::class)->name('public.transparency');

Route::middleware(['auth'])->group(function () {
    Route::get('/donor/dashboard', DonorDashboard::class)->name('public.donor.dashboard');
});

/*
|--------------------------------------------------------------------------
| PDF Receipt & QR Verification Endpoints
|--------------------------------------------------------------------------
*/
Route::middleware(['throttle:30,1'])->group(function () {
    Route::get('/receipts/download/{reference}', [ReceiptController::class, 'downloadPdf'])->name('receipts.download');
    Route::get('/receipts/verify/{hash}', [ReceiptController::class, 'verifyQr'])->name('receipts.verify');
});

/*
|--------------------------------------------------------------------------
| Payment Gateway Webhook Endpoints (CSRF Excluded, Throttled)
|--------------------------------------------------------------------------
*/
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/webhooks/mpesa', MpesaWebhookController::class)->name('webhooks.mpesa')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::post('/webhooks/flutterwave', FlutterwaveWebhookController::class)->name('webhooks.flutterwave')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::post('/webhooks/dpo', DpoWebhookController::class)->name('webhooks.dpo')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::post('/webhooks/paypal', PaypalWebhookController::class)->name('webhooks.paypal')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::post('/webhooks/nowpayments', NowpaymentsWebhookController::class)->name('webhooks.nowpayments')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
});

/*
|--------------------------------------------------------------------------
| SEO Dynamic & Shared Hosting Deploy Endpoints
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemapXml'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robotsTxt'])->name('seo.robots');
Route::match(['get', 'post'], '/api/deploy/webhook', \App\Http\Controllers\DeployWebhookController::class)
    ->name('deploy.webhook')
    ->middleware(['throttle:30,1'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| Admin Management Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/campaigns', CampaignManager::class)->name('admin.campaigns');
    Route::get('/donations', DonationManager::class)->name('admin.donations');
    Route::get('/gateways', PaymentGatewaySettings::class)->name('admin.gateways');
    Route::get('/logs', PaymentLogsViewer::class)->name('admin.logs');
    Route::get('/volunteers', VolunteerManager::class)->name('admin.volunteers');
    Route::get('/events', \App\Livewire\Admin\EventManager::class)->name('admin.events');
    Route::get('/talents', \App\Livewire\Admin\TalentManager::class)->name('admin.talents');
    Route::get('/programs', \App\Livewire\Admin\ProgramManager::class)->name('admin.programs');
    Route::get('/reports', FinancialReports::class)->name('admin.reports');
    Route::get('/transparency', TransparencyManager::class)->name('admin.transparency');
    Route::get('/users', UserManager::class)->name('admin.users');
    Route::get('/cms', CmsSettingsManager::class)->name('admin.cms');
    Route::get('/profile', \App\Livewire\Admin\ProfileManager::class)->name('admin.profile');
});

// Authentication Stub Routes
Route::get('/login', function () {
    $user = \App\Models\User::first();
    if ($user) {
        auth()->login($user);
        return redirect()->route('admin.dashboard');
    }
    return 'Admin user not found. Run migrate:fresh --seed.';
})->name('login')->middleware('throttle:10,1');

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('home');
})->name('logout');
