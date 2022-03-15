<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'full_name' => 'string',
            'email' => 'email',
            'password' => 'string'
        ]);

        $user = Auth::user();
        $user->full_name = $request->full_name ?? $user->full_name;
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->save();

        return response()->json($user);
    }

    public function delete(): JsonResponse
    {
        $user = Auth::user();

        if ($user->delete()) {
            return response()->json([
                'message' => 'User Deleted Successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Couldn\'t Delete User!'
            ]);
        }
    }
}
