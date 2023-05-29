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
            ], 422);
        }
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => 'emails ou mot de passe incorrect'
            ], 403);
        }
        $user = User::where('email', $request->email)->with(['roles'])->first();
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
    //logout a user
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "logged out successfully"
        ]);
    }

    //register a user
    public function register(Request $request)
    {
        $registerValidator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|string',
            'full_name' => 'required',
            'password_confirmation' => 'required'
        ]);
        if ($registerValidator->fails()) {
            return response()->json([
                /**
                 * pour verifier si un champs occasionne des errors, on peut
                 * faire errors->has('<cham>')
                 * pour recuperer et afficher le message, on fait: 
                 * errors->first('<champ>')
                 */
                'errors' => $registerValidator->errors()
            ], 422);
        }
        $user = new User();
        $user->full_name = $request->full_name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->state = 'not-validated';
        $user->save();
        $token = $user->createToken($user->email)->plainTextToken;
        return response()->json(['response' => $user->full_name . ' created successfully', 'user' => $user, 'token' => $token]);
    }
}
