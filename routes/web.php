<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\Footnote\Node\FootnoteRef;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/conditions', [PublicController::class, 'conditions'])->name('conditions');
Route::get('/category/{category:name}/ads', [PublicController::class, 'adsByCategory'])->name('category.ads');
Route::get('/user/{user:name}/ads', [AdController::class, 'adsByUser'])->name('user.ads');
Route::get("/search", [PublicController::class, 'search'])->name('search');

// Rutas de anuncios
Route::get('/destroy/{ad}', [AdController::class, 'destroy'])->name('ad.destroy');
Route::get('/ads/create', [AdController::class,'create'])->name('ads.create');
Route::get('/ads/{ad}', [AdController::class,'show'])->name('ads.show');
Route::post('/locale/{locale}', [PublicController::class, 'setLocale'])->name('locale.set');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::middleware(['auth'])->group(function(){
    Route::get('/revisor/become', [RevisorController::class,'becomeRevisor'])->name('revisor.become');
    Route::get('/revisor/{user}/make',  [RevisorController::class,'makeRevisor'])->name('revisor.make');
});

Route::middleware(['isRevisor'])->group(function(){
    Route::get('/revisor', [RevisorController::class, 'index'])->name('revisor.home');
    Route::patch('/revisor/ad/{ad}/accept', [RevisorController::class, 'acceptAd'])->name('revisor.ad.accept');
    Route::patch('/revisor/ad/{ad}/reject', [RevisorController::class, 'rejectAd'])->name('revisor.ad.reject');
});

Route::middleware(['isAdmin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
    Route::patch('/admin/user/{user}/delete', [AdminController::class, 'deleteRevisor'])->name('deleteRevisor');
    Route::get('/admin/{user:name}/adsrevised', [AdminController::class, 'adsByRevisor'])->name('adsByRevisor');
});


