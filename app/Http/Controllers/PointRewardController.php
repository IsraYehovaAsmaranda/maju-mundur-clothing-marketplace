<?php

namespace App\Http\Controllers;

use App\Helpers\CommonResponse;
use App\Models\PointReward;
use App\Models\PointRewardRedeem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointRewardController extends Controller
{
    public function index()
    {
        return CommonResponse::success(PointReward::paginate(6), "Successfully fetched data");
    }

    public function redeem(Request $request)
    {
        $request->validate(
            [
                "reward_id" => "required|exists:point_rewards,id"
            ]
        );
        try {
            $user = $request->user();
            $reward = PointReward::findOrFail($request->reward_id);

            DB::beginTransaction();

            if ($user->points < $reward->cost) {
                return CommonResponse::error("Insufficient points", 403);
            }
            $user->points -= $reward->cost;
            $user->save();

            $redeem = PointRewardRedeem::create(
                [
                    "customer_id" => $user->id,
                    "reward_id" => $reward->id,
                    "cost" => $reward->cost,
                    "redeem_date" => Carbon::now()
                ]
            );
            $pointLeft = $user->points;
            $data = [
                "points_left" => $pointLeft,
                "redeem" => $redeem
            ];
            DB::commit();
            return CommonResponse::success($data, "Reward redeemed successfully");
        } catch (\Throwable $th) {
            DB::rollBack();
            return CommonResponse::error("Reward not found", 404, $th->getMessage());
        }
    }
}
