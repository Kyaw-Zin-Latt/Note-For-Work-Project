<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LanguageStringController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [WelcomeController::class, "test"]);

Route::controller(SocialLoginController::class)->group(function (){
    Route::get('/auth/{provider}', "redirect")->name("redirect");
    Route::get('/auth/{provider}/callback', "callback")->name("callback");
});


Route::get('/backup', function(){
    try{
        $exitCode = shell_exec("backup:run --only-db");
    }catch(Throwable $e){
        return $e->getMessage();
    }
    dd($exitCode, Artisan::output());
})->name("backup");

//Route::get('/language/{locale}',[LanguageController::class,'test'])->name('test');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    // Global Search
    Route::controller(SearchController::class)->group(function (){
        Route::get("global-search", "index")->name("global.search");
    });

    // Dashboard
    Route::get('/test', [DashboardController::class, 'test'])->name('test');
    Route::prefix("/dashboard")->controller(DashboardController::class)->group(function (){

        Route::get('/',  'index')->name('dashboard');
//        Route::get('/issue-filter-by-year', 'index')->name('dashboard.issueFilterByYear');
    });

    // Issue

    Route::resource('/issue',IssueController::class);

    // Team
    Route::prefix("team")->name("team.")->controller(TeamController::class)->group(function (){
        Route::get('/team-pdf',"teamPdf")->name("exportPdf");
        Route::get('/team-csv/export/{extension}',"CSVExport")->name('exportCSV');
        Route::post('/team-csv/import',"CSVImport")->name('importCSV');
        Route::put('/status/{team}','status')->name('status');
    });
    Route::resource('/team',TeamController::class);

    // Project
    Route::prefix("project")->name("project.")->controller(ProjectController::class)->group(function (){
        Route::get('/project-pdf',"projectPdf")->name("exportPdf");
        Route::get('/project-csv/export/{extension}',"CSVExport")->name('exportCSV');
        Route::post('/project-csv/import',"CSVImport")->name('importCSV');
        Route::put('/status/{project}','status')->name('status');
    });
    Route::resource("project",ProjectController::class);

    // Language
    Route::prefix('language')->name('language.')->controller(LanguageController::class)->group(function (){
        Route::put('/default/{language}','default')->name('default');
        Route::get('/change-language/{lang}','changeLanguage')->name('changeLanguage');
        Route::put('/status/{language}','status')->name('status');
    });
    Route::resource("language",LanguageController::class);

    // language string
    Route::resource("language/{language}/language-string",LanguageStringController::class);



});
