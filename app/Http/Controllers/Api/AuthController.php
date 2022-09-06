<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required']);

        if (!$validator) {
            return response()->json([
                'message' => 'User could not be verified!',
            ]);
        }

        $user = User::where('email',$request->input('email'))->first();

        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                $newToken = Str::random(60);
                $user->update(['api_token' => $newToken]);
                return response()->json([
                    'user' => $user,
                    'new_token' => $newToken
                ]);
            }
        }

    }
}
