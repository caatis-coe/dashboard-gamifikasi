<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\UsersManagementController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if (!session()->has('api_token')) {
        return redirect('/login');
    }

    $user = session('user');
    return view('dashboard', compact('user'));
});



Route::get('/profile', [ProfilePageController::class, 'index'])->name('profile');
Route::put('/profile/update', [ProfilePageController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [ProfilePageController::class, 'edit'])->name('profile.edit');


Route::get('/', function () {
    return view('welcome');
});



// USER MANAGEMENT ROUTES
Route::get('/users', [UsersManagementController::class, 'index'])->name('users.list');
Route::get('/users/create', [UsersManagementController::class, 'create'])->name('users.create');
Route::post('/users', [UsersManagementController::class, 'store'])->name('users.store');
Route::delete('/users/{id}', [UsersManagementController::class, 'delete'])->name('users.delete');
Route::get('/users/{id}/edit', [UsersManagementController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
