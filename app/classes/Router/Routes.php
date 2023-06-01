<?php

use App\Classes\Controllers\AuthController;
use App\Classes\Controllers\CustomController;
use App\Classes\Router\Route;

Route::post('/auth/login', AuthController::class, 'auth');
Route::post('/auth/refresh', AuthController::class, 'refresh');
Route::get('/custom_page', CustomController::class);