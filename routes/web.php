<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProjectController as WebProjectController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\ContactController;

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Projects
Route::get('/projects', [WebProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/category/{slug}', [WebProjectController::class, 'byCategory'])->name('projects.category');
Route::get('/projects/{slug}', [WebProjectController::class, 'show'])->name('projects.show');

// Booking & Quote Forms
Route::post('/booking', [ContactController::class, 'storeBooking'])->name('booking.store');
Route::post('/quote', [ContactController::class, 'storeQuote'])->name('quote.store');
