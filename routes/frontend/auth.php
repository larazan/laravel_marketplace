<?php
use App\Http\Controllers\CustomRegisterController;
Route::get('/login', [CustomRegisterController::class, 'form_login'])->name('form_login');
Route::get('/logout', [CustomRegisterController::class, 'logout'])->name('logout');
Route::post('/login/cek', [CustomRegisterController::class, 'form_login_action'])->name('form_login_action');
Route::get('/register', [CustomRegisterController::class, 'form_register'])->name('form_register');
Route::post('/register', [CustomRegisterController::class, 'form_register_action'])->name('form_register_action');