<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $users = User::where('id' , '!=' , $user->id)->latest()->get();
        return response()->json(['status' => 200 , 'data' => $users]);
    }

    public function show($id): JsonResponse
    {
        $user = User::where('id' , $id)->first();
        return response()->json(['status' => 200 , 'data' => $user]);
    }

    public function update($id,Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'password' => 'min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'fail', 'data' => $validator->errors()]);
        }
        User::where('id' , $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json(['status' => 200 , 'message' => 'Updated successfully']);
    }

    public function destroy($id): JsonResponse
    {
        User::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
    }
}
