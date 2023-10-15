<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LogOutController;
use App\Http\Middleware\EnsureProfileIsCompleted;
use App\Livewire\CompleteProfile;
use App\Livewire\Faq;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;


Route::get('/', HomePage::class)->middleware(EnsureProfileIsCompleted::class)->name('home');

Route::get('/faq', Faq::class);

Route::get('/complete-profile', CompleteProfile::class)->middleware('auth')->name('complete.profile');

Route::get('/election', function() {
    dd('only authenticated users');
})->middleware('auth')->name('election.index');

Route::post('/logout', LogOutController::class)->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'signin'])->name('login');
Route::get('/callback', [GoogleAuthController::class, 'callback']);
