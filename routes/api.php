<?php

use App\Http\Controllers\Api\ProdukApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/produk/{code}",[ProdukApiController::class,  'getProduk'])->name("api.getproduk");
