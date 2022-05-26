<?php

use Illuminate\Support\Facades\Route;
use Surgems\RedirectUrls\Controllers\RedirectController;

Route::get('/{slug}', ['\\'.RedirectController::class, 'createRedirect'])->name('redirect-url');
Route::get('/{slug}/{extra}', ['\\'.RedirectController::class, 'createRedirect'])->where('extra', '.*')->name('redirect-url');