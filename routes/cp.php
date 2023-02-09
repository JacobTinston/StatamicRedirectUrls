<?php

use Illuminate\Support\Facades\Route;
use Surgems\RedirectUrls\Controllers\DashboardController;
use Surgems\RedirectUrls\Controllers\ImportRedirectsController;

Route::get('redirect-urls/dashboard', '\\'. DashboardController::class)->name('redirect-urls.dashboard');
Route::get('redirect-urls/import', ['\\'. ImportRedirectsController::class, 'index'])->name('redirect-urls.import');
Route::post('redirect-urls/import', ['\\'. ImportRedirectsController::class, 'store'])->name('redirect-urls.import.submit');