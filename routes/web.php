<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'bookCount' => \App\Models\Book::count(),
        'userCount' => \App\Models\User::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Route dengan Middleware Auth & Spatie Permission
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('permission:manage-users')->group(function () {
        Route::get('/users/roles', [UserRoleController::class, 'index'])->name('users.roles.index');
        Route::patch('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.roles.update');
    });
    
    // Semua role bisa melihat daftar buku (view-books)
    Route::get('/books', [BookController::class, 'index'])
        ->middleware('permission:view-books')
        ->name('books.index');

    // Hanya Admin & Dosen yang bisa menambah buku (create-books)
    Route::get('/books/create', [BookController::class, 'create'])
        ->middleware('permission:create-books')
        ->name('books.create');
    Route::post('/books', [BookController::class, 'store'])
        ->middleware('permission:create-books')
        ->name('books.store');

    // Hanya Admin & Dosen yang bisa mengedit buku (edit-books)
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->middleware('permission:edit-books')
        ->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])
        ->middleware('permission:edit-books')
        ->name('books.update');

    // Hanya Admin yang bisa menghapus buku (delete-books)
    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('permission:delete-books')
        ->name('books.destroy');
});

require __DIR__.'/auth.php';