<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\UserBorrowController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BorrowManagementController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Smart Redirect (Root URL)
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role->role_name === 'Employee'
            ? redirect()->route('admin.borrows.index')
            : redirect()->route('catalog.index');
    }
    return redirect()->route('login');
});

// =========================================================
// EMAIL VERIFICATION ROUTES
// =========================================================
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', function (Request $request) {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended('/')
            : view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// =========================================================
// STUDENT ROUTES
// =========================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    
    // Cart Routes
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{book}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    
    // Student Borrow History
    Route::get('/my-books', [UserBorrowController::class, 'index'])->name('user.borrows');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================
// EMPLOYEE / ADMIN ROUTES
// =========================================================
Route::middleware(['auth', 'verified', 'employee'])->prefix('admin')->name('admin.')->group(function () {

    // User Management
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);

    // Borrow Requests
    Route::get('/borrows', [BorrowManagementController::class, 'index'])->name('borrows.index');
    Route::post('/borrows/{transaction}/approve', [BorrowManagementController::class, 'approve'])->name('borrows.approve');
    Route::post('/borrows/{transaction}/reject', [BorrowManagementController::class, 'reject'])->name('borrows.reject');
    Route::post('/borrows/{transaction}/return', [BorrowManagementController::class, 'returnBook'])->name('borrows.return');

    // Book Inventory
    Route::get('/books/bulk-edit', [BookController::class, 'bulkEdit'])->name('books.bulk-edit');
    Route::post('/books/bulk-update', [BookController::class, 'bulkUpdate'])->name('books.bulk-update');
    Route::resource('books', BookController::class)->except(['show', 'edit', 'update']);

    // Authors & Categories Management
    Route::resource('authors', AuthorController::class)->only(['index', 'store', 'destroy']);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__ . '/auth.php';