<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// routes/api.php
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\AlbumController;

Route::get('artists', [ArtistController::class, 'index']);
Route::get('artists/{id}', [ArtistController::class, 'show'])->whereNumber('id');


Route::get('album', [AlbumController::class, 'index']);
Route::get('album/{id}', [AlbumController::class, 'show'])->whereNumber('id');
