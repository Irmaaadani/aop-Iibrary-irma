<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::user()
        ? redirect('/books')
        : redirect()->route('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::middleware('auth')->group(function () {

    // Books
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}/books', [CategoryController::class, 'books']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Loans
    Route::get('/loans', [LoanController::class, 'index']);    
    Route::get('/loans/data', [LoanController::class, 'data']); 
    Route::post('/loans', [LoanController::class, 'store']);
    Route::put('/loans/{id}', [LoanController::class, 'update']);
    Route::delete('/loans/{id}', [LoanController::class, 'destroy']);


});

//User
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/add-user', [UserController::class, 'form']);
    Route::post('/user-store', [UserController::class, 'createStore']);
    Route::get('/edit-user/{id}', [UserController::class, 'edit']);
    Route::put('/user-update/{id}', [UserController::class, 'saveChanges']);
    Route::delete('/user-delete/{id}', [UserController::class, 'destroy']);

});





