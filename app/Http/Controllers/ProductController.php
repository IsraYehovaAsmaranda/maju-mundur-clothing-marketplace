<?php

namespace App\Http\Controllers;

use App\Helpers\CommonResponse;
use App\Models\Product;
use ErrorException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::paginate(6);
            return CommonResponse::success($products);
        } catch (\Throwable $th) {
            return CommonResponse::error("Failed to fetch products", 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                "name" => "required",
                "description" => "required",
                "price" => "required|numeric",
                "stock" => "required|integer",
            ]
        );
        try {
            $products = Product::create([
                "merchant_id" => $request->user()->id,
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "stock" => $request->stock,
            ]);
            return CommonResponse::success($products);
        } catch (\Throwable $th) {
            return CommonResponse::error("Failed to create products", 500, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return CommonResponse::success($product);
        } catch (\Throwable $th) {
            return CommonResponse::error("Product not found", 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                "name" => "required",
                "description" => "required",
                "price" => "required|numeric",
                "stock" => "required|integer",
            ]
        );
        try {
            $product = Product::findOrFail($id);
            if ($product->merchant->id != $request->user()->id) {
                return CommonResponse::error("You have no permission to update this product", 403);
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->save();
            return CommonResponse::success($product);
        } catch (\Throwable $th) {
            return CommonResponse::error("Product not found", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->merchant->id != $request->user()->id) {
                return CommonResponse::error("You have no permission to delete this product", 403);
            }
            $product->delete();
            return CommonResponse::success(null, "Product deleted successfully");
        } catch (\Throwable $th) {
            return CommonResponse::error("Product not found", 404);
        }
    }
}
