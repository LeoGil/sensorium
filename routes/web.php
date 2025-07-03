<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\RoastLevelController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('brands', BrandController::class)->names('brands');
    Route::resource('coffees', CoffeeController::class)->names('coffees');
    Route::resource('roast-levels', RoastLevelController::class)->names('roast-levels');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
