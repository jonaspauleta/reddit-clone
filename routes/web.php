<?php

use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityPostController;
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

Route::get('/r/{slug}', [CommunityController::class, 'show'])->name('community.show');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::resource('/dashboard/communities', CommunityController::class);
    Route::resource('/dashboard/communities.posts', CommunityPostController::class);

});

require __DIR__.'/auth.php';
