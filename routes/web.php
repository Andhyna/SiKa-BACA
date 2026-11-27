<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/* ZONA GUEST (Hanya untuk yang belum login) */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

/* ZONA AUTH (Wajib Login) */
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Buku (termasuk books.show)
    Route::resource('books', BookController::class);

    // Modul Anggota (termasuk members.show)
    Route::resource('members', MemberController::class);

    // Modul Peminjaman / Sirkulasi
    Route::resource('borrowings', BorrowingController::class)
        ->only(['index', 'create', 'store', 'update']);

    // Modul Kategori: Tulis hanya untuk Admin, Lihat untuk Admin & Petugas
    Route::middleware('can:manage-categories')->group(function () {
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    /* ZONA KHUSUS ADMIN (Dilindungi Gate manage-users) */
    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/{user}', fn () => abort(404))->name('users.show');
    });
});