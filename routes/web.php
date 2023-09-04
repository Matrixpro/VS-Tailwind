<?php

use App\Http\Controllers\CommunityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CommunityController::class, 'index'])->name('communities');

Route::get('/welcome', function () {
    return inertia('welcome');
});

Route::get('/filter_locations/{filter_params}', [CommunityController::class, 'filterAndSort']);

