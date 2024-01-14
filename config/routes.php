<?php

declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Http\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/add-product', [ProductController::class, 'index']);
Route::post('/add-product', [ProductController::class, 'add']);
