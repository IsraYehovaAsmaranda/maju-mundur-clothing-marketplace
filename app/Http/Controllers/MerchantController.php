<?php

namespace App\Http\Controllers;

use App\Helpers\CommonResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function GetCustomers(Request $request) {
        $merchant = $request->user();

        // Ambil semua customer yang pernah membeli produk milik merchant
        $customers = Transaction::whereHas('details.product', function ($query) use ($merchant) {
            $query->where('merchant_id', $merchant->id);
        })->with('customer')->get()->pluck('customer')->unique('id')->values();

        return CommonResponse::success($customers, "List of customers who made purchases");
    }
}
