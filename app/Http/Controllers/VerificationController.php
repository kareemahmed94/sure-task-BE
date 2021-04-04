<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyUser(Request $request): JsonResponse
    {
        $code = $request->input('user_code');
        $user = User::where('email' , $request->input('email'))->first();
        if ($code == $user->verification_code) {
            $user->email_verified_at = Carbon::now();
            $user->update();
            return response()->json(['status' => 200, 'message' => 'User verified Successfully']);
        }
        return response()->json(['status' => 500, 'message' => 'Wrong Code try again']);
    }
}
