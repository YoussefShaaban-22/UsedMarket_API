<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $User = User::all();
        return $User;
    }

    public function getbyEmail($email)
    {
        $User = User::where('email',$email)->first();
        return $User;
    }

    public function getbyId($id)
    {
        $User = User::where('id',$id)->first();
        return $User;
    }

    public function register(Request $request)
    {
        $fileds = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "user_type" => "required|string",
            "phone" => "required|string",
            "address" => "required|string",
            "password" => "required|string|confirmed"
        ]);

        $verification_code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 6)), 0, 6);

        $user = User::create([
            "name"  =>  $fileds['name'],
            "email"  =>  $fileds['email'],
            "user_type"  =>  $fileds['user_type'],
            "phone"  =>  $fileds['phone'],
            "address"  =>  $fileds['address'],
            "password"  =>  bcrypt($fileds['password']),
            'verification_code' => $verification_code,
            'status' => "no"
        ]);
        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            "user"  =>  $user,
            "userToken"  =>  $token
        ];

        return response($response, 201);
    }

    public function registerstaff(Request $request)
    {
        $fileds = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "user_type" => "required|string",
            "seller_id" => "",
            "phone" => "required|string",
            "address" => "required|string",
            "password" => "required|string|confirmed"
        ]);

        $verification_code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 6)), 0, 6);

        $user = User::create([
            "name"  =>  $fileds['name'],
            "email"  =>  $fileds['email'],
            "user_type"  =>  $fileds['user_type'],
            "seller_id"  =>  $fileds['seller_id'],
            "phone"  =>  $fileds['phone'],
            "address"  =>  $fileds['address'],
            "password"  =>  bcrypt($fileds['password']),
            'verification_code' => $verification_code,
            'status' => "Yes"
        ]);
        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            "user"  =>  $user,
            "userToken"  =>  $token
        ];

        return response($response, 201);
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);

        $user = User::where("email", $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                "message" => "Wrong password or wrong email"
            ], 401);
        }

        if ($user->status === 'no') {
            return response([
                "message" => "Please verify your account"
            ], 403);
        }

        $token = $user->createToken('userToken', ['server:update'])->plainTextToken;
        $response = [
            "user" => $user,
            "userToken" => $token
        ];

        return response($response, 201);
    }

    public function verify(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string|email",
            "verification_code" => "required|string"
        ]);

        $user = User::where('email', $fields['email'])
            ->where('verification_code', $fields['verification_code'])
            ->first();

        if (!$user) {
            return response([
                "message" => "Invalid verification code or email"
            ], 401);
        }

        $user->status = 'yes';
        $user->save();

        return response([
            "message" => "User verified successfully"
        ], 200);
    }

    public function logOut(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            "message" => "LogOut Done"
        ];
    }
}
