<?php

use Illuminate\Support\Facades\Route;
use Surgems\RedirectUrls\Controllers\DashboardController;
use Surgems\RedirectUrls\Controllers\ImportRedirectsController;
use Surgems\RedirectUrls\Controllers\RedirectController;

Route::get('redirect-urls/dashboard', '\\'. DashboardController::class)->name('redirect-urls.dashboard');
Route::get('redirect-urls/import', ['\\'. ImportRedirectsController::class, 'index'])->name('redirect-urls.import');
Route::post('redirect-urls/import', ['\\'. ImportRedirectsController::class, 'store'])->name('redirect-urls.import.submit');
Route::get('redirect-urls/edit/{id}', ['\\'. RedirectController::class, 'update'])->name('redirect-urls.edit');
Route::get('redirect-urls/delete/{id}', ['\\'. RedirectController::class, 'delete'])->name('redirect-urls.delete');