<?php

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\Auth\AuthenticationController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/contacts', [ContactController::class,'index'])->name('contacts');
    Route::post('/contact/add', [ContactController::class,'store'])->name('contact.add');
    Route::delete('contact/delete', [ContactController::class,'destroy'])->name('contact.delete');
    Route::put('contact/edit', [ContactController::class,'update'])->name('contact.edit');
});

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout']);
Route::post('/register', [AuthenticationController::class, 'register']);
