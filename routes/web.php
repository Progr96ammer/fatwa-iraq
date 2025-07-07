<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\CategoryController;

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

Route::post('/notifications/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.markAllRead');
Route::get('articles/{id}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::get('/info/{page}', [\App\Http\Controllers\InfoPageController::class, 'show'])->name('info.show');
Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->only(['index', 'show']);
Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->only(['index', 'show']);
Route::get('/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/library', [\App\Http\Controllers\FrontendController::class, 'library'])->name('library');
Route::get('/', [\App\Http\Controllers\FrontendController::class, 'home'])->name('home');
Route::get('/fatwas/answered', [\App\Http\Controllers\FatwaController::class, 'index'])->name('fatwas.index');
Route::get('/fatwas/{id}', [\App\Http\Controllers\FatwaController::class, 'show'])->name('fatwas.show');
Route::get('auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/dashboard', [\App\Http\Controllers\FrontendController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/fatwas', [\App\Http\Controllers\Admin\FatwaController::class, 'index'])->name('admin.fatwas.index');
    Route::get('/admin/fatwas/unassigned', [\App\Http\Controllers\Admin\FatwaController::class, 'unassigned'])->name('admin.fatwas.unassigned');
    Route::post('/fatwas/{fatwa}/assign', [\App\Http\Controllers\Admin\FatwaController::class, 'assign'])->name('admin.fatwas.assign');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->except(['index','show']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->except(['index','show']);
    Route::post('/info/{page}', [\App\Http\Controllers\InfoPageController::class, 'update'])->name('info.update');
    Route::resource('/articles', \App\Http\Controllers\ArticleController::class)->except(['show']);
});

Route::middleware(['role:sheikh'])->prefix('sheikh')->group(function () {
    Route::get('/dashboard', function () {
        return view('sheikh.dashboard');
    })->name('sheikh.dashboard');
    Route::get('/fatwas', [\App\Http\Controllers\Sheikh\FatwaController::class, 'index'])->name('sheikh.fatwas.index');
    Route::post('/fatwas/{fatwa}/answer', [\App\Http\Controllers\Sheikh\FatwaController::class, 'answer'])->name('sheikh.fatwas.answer');
});

Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::resource('fatwas', \App\Http\Controllers\FatwaController::class)->only(['create', 'store']);
});




require __DIR__.'/auth.php';
