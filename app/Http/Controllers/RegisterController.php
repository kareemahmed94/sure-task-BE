<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'fail', 'data' => $validator->errors()]);
        }
        $code = rand(100000,999999);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'verification_code' => $code,
        ]);
//        Mail::to($user->email)->send(new \App\Mail\VerifyUser($user));

        $user->notify(new VerifyUser($code));

        return response()->json(['status' => 200, 'message' => 'User verified Successfully' , 'data' => $user]);
    }
}
