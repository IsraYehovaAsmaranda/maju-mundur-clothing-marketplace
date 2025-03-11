<?php

namespace App\Http\Controllers;

use App\Helpers\CommonResponse;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function createTransaction(Request $request)
    {
        $request->validate([
            "details" => "required|array",
            "details.*.product_id" => "required|exists:products,id",
            "details.*.quantity" => "required|integer",
        ]);

        try {
            $user = $request->user();
            $transaction = Transaction::create([
                "customer_id" => $user->id,
                "transaction_date" => Carbon::now()
            ]);

            $totalPrice = 0;

            foreach ($request->details as $detail) {
                $product = Product::findOrFail($detail["product_id"]);
                if ($product->stock < $detail["quantity"]) {
                    DB::rollback();
                    return CommonResponse::error("Insufficient quantity of product", 400);
                }
                $product->stock -= $detail["quantity"];
                $product->save();

                $totalPrice += $detail["quantity"] * $product->price;
                $details[] = [
                    "product_id" => $product->id,
                    "quantity" => $detail["quantity"],
                    "sale_price" => $product->price
                ];
            }
            $transaction->details()->createMany($details);

            $points = 1;

            if ($totalPrice >= 200000)
                $points = 5;
            elseif ($totalPrice >= 130000)
                $points = 3;
            $user->points += $points;
            $user->save();

            $data = [
                "points_earned" => $points,
                "transaction" => $transaction->load('details')
            ];

            DB::commit();
            return CommonResponse::success($data, "Transaction created successfully");
        } catch (\Throwable $th) {
            DB::rollback();
            return CommonResponse::error("Failed to create transaction", 400, $th->getMessage());
        }
    }
}
