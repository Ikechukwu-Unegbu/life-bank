<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
     {
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|string'
         ]);
         $credentials = $request->only('email', 'password');
     
         if (Auth::attempt($credentials)) {
             $user = Auth::user();;
             $accessToken = $user->createToken('access_token', ['*'], Carbon::now()->addMinutes(720));
             $refreshToken = $user->createToken('refresh_token', ['refresh'], Carbon::now()->addMinutes(7 * 24 * 60));
             return response()->json([
                 'access_token' => $accessToken,
                 'refresh_token' => $refreshToken,
                 'user' => $user
             ], 200);
         } else {
             return response()->json([
                 'error' => 'Unauthorized'
             ], 401);
         }
     }
}
