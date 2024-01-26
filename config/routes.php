<?php

declare(strict_types=1);

use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Http\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/add-product', [HomeController::class, 'index']);
Route::get('/api/products', [ProductController::class, 'index']);
Route::post('/api/products', [ProductController::class, 'add']);
Route::post('/api/products/delete', [ProductController::class, 'delete']);
