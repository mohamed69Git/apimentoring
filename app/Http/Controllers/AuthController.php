<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login a user
    public function login(Request $request)
    {
        $loginValidator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ],);
        if ($loginValidator->fails()) {
            return response()->json([
                'errors' => $loginValidator->errors()
            ], 403);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => 'emails ou mot de passe incorrect'
            ], 403);
        }
        $user = User::where('email', $request->email)->with(['roles'])->first();
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user->only(['id', 'email', 'full_name', 'roles', 'is_mentor'])
        ]);
    }
    //logout a user
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            "message" => "logged out successfully"
        ]);
    }

    //register a user
    public function register(Request $request)
    {
        $registerValidator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'full_name' => 'required'
        ]);
        if ($registerValidator->fails()) {
            return response()->json([
                'errors' => $registerValidator->errors()
            ], 403);
        }
        $user = new User();
        $user->full_name = $request->full_name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json(['response' => $user->full_name . ' created successfully', 'user' => $user->only(['full_name', 'email']), 'token' => $token]);
    }
}
