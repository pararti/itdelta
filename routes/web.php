<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XmlDataController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-products-csv', [XmlDataController::class, 'generateProductCsv']);

// CRUD для операций с пользователями
Route::resource('users', UserController::class);
