<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Issues\IssueController;
use App\Http\Controllers\YouTrackController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/phpinfo', function () {
    return view('phpinfo');
})->name('phpinfo');

Route::get('/cust', [CustomerController::class, 'getAllCustomers'])->name("cust");
Route::get('/cust/{id}', [CustomerController::class, 'getCustomer'])->name("cust-info");
Route::get('/storage/cust/{id}', [CustomerController::class, 'getMedia'])->name("cust-docs");


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
Route::get('/ytissue/{slug}', [YouTrackController::class, 'show']);

require __DIR__.'/auth.php';
