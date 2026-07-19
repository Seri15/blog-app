<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Author\DashboardController as AuthorDashboardController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes (guests)
|--------------------------------------------------------------------------
*/
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

/*
|--------------------------------------------------------------------------
| Breeze auth routes (login/register/profile)
|--------------------------------------------------------------------------
*/
// Breeze's "Dashboard" nav link and post-login redirect both point here.
// It never renders anything itself - it just sends each role to its own area.
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user instanceof \App\Models\User) {
        return redirect()->route('home');
    }

    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('author.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comments & likes - any logged-in user (admin or author) can comment/like as a reader
    Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/posts/{post:slug}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/posts/{post:slug}/like', [LikeController::class, 'toggle'])->name('posts.like');
});

/*
|--------------------------------------------------------------------------
| ADMIN area - role:admin only. Sees and manages EVERYTHING:
| every post regardless of author, plus categories, tags, site-wide stats.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| AUTHOR area - role:author only. Every query is scoped to that author's
| own posts - they never see categories/tags management or other authors' work.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:author'])->prefix('author')->name('author.')->group(function () {
    Route::get('/dashboard', [AuthorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', AuthorPostController::class)->except(['show']);
});

require __DIR__.'/auth.php';
