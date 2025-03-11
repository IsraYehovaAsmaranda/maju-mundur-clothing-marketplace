<?php

namespace App\Http\Controllers;

use App\Helpers\CommonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function registerCustomer(Request $request)
    {
        $request->validate([
            "email" => "email|required|unique:users,email",
            "password" => "required|confirmed",
            Password::min(8),
            "password_confirmation" => "required|same:password",
            "name" => "required",
            "phone" => "numeric|required",
            "address" => "required"
        ]);


    }
    public function registerMerchant(Request $request)
    {
        $request->validate([
            "email" => "email|required|unique:users,email",
            "password" => "required|confirmed",
            Password::min(8),
            "password_confirmation" => "required|same:password",
            "name" => "required",
            "phone" => "numeric|required",
            "address" => "required"
        ]);

        $user = User::create([
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "name" => $request->name,
            "phone" => $request->phone,
            "address" => $request->address,
        ]);

        return CommonResponse::success($user);
    }
    public function loginCustomer(Request $request)
    {
        $request->validate([
            "email" => "email|required",
            "password" => "required",
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return CommonResponse::error('Invalid email or password');
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $data = [
            'user' => $user,
            'token' => $token
        ];

        return CommonResponse::success($data, "Login successfully");
    }
    public function loginMerchant(Request $request)
    {
        $request->validate([
            "email" => "email|required",
            "password" => "required",
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return CommonResponse::error('Invalid email or password');
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $data = [
            'user' => $user,
            'token' => $token
        ];

        return CommonResponse::success($data, "Login successfully");
    }
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return CommonResponse::success(null, "Logout successfully");
        } catch (\Throwable $th) {
            return CommonResponse::error("Bad Request", 400, $th->getMessage());
        }
    }
}
