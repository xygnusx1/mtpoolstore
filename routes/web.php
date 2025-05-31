<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Issues\IssueController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/phpinfo', function () {
    return view('phpinfo');
})->name('phpinfo');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/issue/{slug}', [IssueController::class, 'show']);

require __DIR__.'/auth.php';
