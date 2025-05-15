<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XmlDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-products-csv', [XmlDataController::class, 'generateProductCsv']);
