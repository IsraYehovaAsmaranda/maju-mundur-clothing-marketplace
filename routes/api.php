<?php

use App\Http\Controllers\AuthController;
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
    Route::get("/", function() {
        return response()->json([
            "message" => "Welcome to the product API!"
        ]);
    });
});