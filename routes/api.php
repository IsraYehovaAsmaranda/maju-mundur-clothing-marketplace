<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix("/auth")->group(function() {
    Route::prefix("/register")->group(function() {
        Route::post("/customer", [AuthController::class, "registerCustomer"]);
        Route::post("/merchant", [AuthController::class, "registerMerchant"]);
    });
    Route::prefix("/login")->group(function() {
        Route::post("/customer", [AuthController::class, "loginCustomer"]);
        Route::post("/merchant", [AuthController::class, "loginMerchant"]);
    });
    Route::get("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
});

Route::prefix("/products")->middleware('auth:sanctum')->group(function() {
    Route::get("/", [ProductController::class,"index"]);
    Route::get("/{product_id}", [ProductController::class, "show"]);
    Route::post("/", [ProductController::class, "store"]);
    Route::put("/{product_id}", [ProductController::class, "update"]);
    Route::delete("/{product_id}", [ProductController::class, "destroy"]);
});

Route::prefix("/transactions")->middleware('auth:sanctum')->group(function() {
    Route::post("/", [TransactionController::class, "createTransaction"]);
});

Route::prefix("/merchant")->middleware('auth:sanctum')->group(function() {
    Route::get("/customers", [MerchantController::class, "GetCustomers"]);
});