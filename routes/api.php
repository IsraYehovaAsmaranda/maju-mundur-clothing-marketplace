<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\PointRewardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix("/auth")->group(function () {
    Route::prefix("/register")->group(function () {
        Route::post("/customer", [AuthController::class, "registerCustomer"]);
        Route::post("/merchant", [AuthController::class, "registerMerchant"]);
    });
    Route::prefix("/login")->group(function () {
        Route::post("/customer", [AuthController::class, "loginCustomer"]);
        Route::post("/merchant", [AuthController::class, "loginMerchant"]);
    });
    Route::get("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix("/products")->group(function () {
        Route::get("/", [ProductController::class, "index"]);
        Route::get("/{product_id}", [ProductController::class, "show"]);
        Route::post("/", [ProductController::class, "store"])->middleware("can:create product");
        Route::put("/{product_id}", [ProductController::class, "update"])->middleware("can:update product");
        Route::delete("/{product_id}", [ProductController::class, "destroy"])->middleware("can:delete product");
    });

    Route::prefix("/transactions")->group(function () {
        Route::post("/", [TransactionController::class, "createTransaction"])->middleware("can:buy product");
    });

    Route::prefix("/merchant")->group(function () {
        Route::get("/customers", [MerchantController::class, "GetCustomers"])->middleware("can:get customer report");
    });
    Route::prefix("/rewards")->group(function () {
        Route::get("/", [PointRewardController::class, "index"]);
        Route::post("/redeem", [PointRewardController::class, "redeem"])->middleware("can:redeem points");
    });
});