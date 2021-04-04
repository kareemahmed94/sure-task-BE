<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'fail', 'data' => $validator->errors()]);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user) {
            if (!auth()->attempt(['email' => $email, 'password' => $password],$request->input('remember'))) {
                return response()->json(['status' => 500, 'message' => 'Wrong password']);
            }
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['status' => 200, 'message' => 'Welcome back', 'data' => $user , 'token' => $token]);
        } else {
            return response()->json(['status' => 500, 'message' => 'Wrong Email']);
        }
    }

    public function user(Request $request): JsonResponse
    {
        $user = User::where('id' , $request->user()->id )->first();
        return response()->json(['status' => 200, 'data' => $user]);
    }

}
