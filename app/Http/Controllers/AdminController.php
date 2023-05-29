<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * login a new administrator
     */
    public function login(Request $request)
    {
        $adminValidator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($adminValidator->fails())
            return response()->json([
                'errors' => $adminValidator->errors()
            ]);

        if (!Auth::guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'erros' => 'email ou mot de passe incorrect'
            ]);
        }
        $admin = Admin::where('email', $request->email)->first();
        $token = $admin->createToken($admin->email)->plainTextToken;
        return response()->json([
            'message' => 'connected successfully',
            'admin' => $admin,
            'token' => $token
        ]);
    }
    /**
     * Lgoout an administrator
     */
    public function logout(Request $request)
    {
        Auth::guard('api')->logout();
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'logged out successfully'
        ]);
    }
}
