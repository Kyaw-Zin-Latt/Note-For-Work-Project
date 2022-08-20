<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LanguageStringController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Route::get('/language/{locale}',[LanguageController::class,'test'])->name('test');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Project
    Route::prefix("project")->name("project.")->controller(ProjectController::class)->group(function (){
        Route::get('/project-pdf',"projectPdf")->name("exportPdf");
        Route::get('/project-csv/export/{extension}',"CSVExport")->name('exportCSV');
        Route::put('/status/{project}','status')->name('status');
    });
    Route::resource("project",ProjectController::class);

    // Language
    Route::resource("language",LanguageController::class);
    Route::prefix('language')->name('language.')->controller(LanguageController::class)->group(function (){
        Route::put('/default/{language}','default')->name('default');
        Route::get('/change-language/{lang}','changeLanguage')->name('changeLanguage');
        Route::put('/status/{language}','status')->name('status');
    });

    // language string
    Route::resource("language/{language}/language-string",LanguageStringController::class);



});
