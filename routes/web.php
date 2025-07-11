<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrewingMethodController;
use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\RoastLevelController;
use App\Http\Controllers\ContainerTypeController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\GrinderController;
use App\Http\Controllers\WaterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('brands', BrandController::class)->names('brands')->except(['show']);

    Route::resource('coffees', CoffeeController::class)->names('coffees')->except(['show']);

    Route::resource('roast-levels', RoastLevelController::class)->names('roast-levels')->except(['show']);
    Route::post('roast-levels/create-default', [RoastLevelController::class, 'createDefault'])->name('roast-levels.create-default');

    Route::resource('container-types', ContainerTypeController::class)->names('container-types')->except(['show']);

    Route::resource('grinders', GrinderController::class)->names('grinders')->except(['show']);
    
    Route::resource('filters', FilterController::class)->names('filters')->except(['show']);

    Route::resource('waters', WaterController::class)->names('waters')->except(['show']);

    Route::resource('brewing-methods', BrewingMethodController::class)->names('brewing-methods')->except(['show']);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
