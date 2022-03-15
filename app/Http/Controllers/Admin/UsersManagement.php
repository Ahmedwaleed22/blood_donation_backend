<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersManagement extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'isAdmin']);
    }

    public function checkAdmin() {
        return true;
    }

    public function index() {
        return User::all();
    }

    public function delete($id): JsonResponse
    {
        if (User::all()->find($id)->delete()) {
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
