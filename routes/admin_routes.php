<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\TracksController;
use App\Http\Controllers\Admin\DashboardController;


$prefixAdmin = config('zvn.url.prefix_admin'); //admin96

Route::prefix($prefixAdmin)
    // ->middleware(['permission.admin', 'user.permission'])
    ->group(function () {

        // ====================== DASHBOARD ======================
        $controllerName = 'dashboard';
        Route::controller(DashboardController::class)->group(function () use ($controllerName) {
            Route::get('/', 'index')->name($controllerName);
        });

        // ====================== ARTIST ======================
        $controllerName = 'artist';
        Route::prefix($controllerName)
            ->controller(ArtistController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== ALBUM ======================
        $controllerName = 'album';
        Route::prefix($controllerName)
            ->controller(AlbumController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== TRACKS ======================
        $controllerName = 'tracks';
        Route::prefix($controllerName)
            ->controller(TracksController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

    });
