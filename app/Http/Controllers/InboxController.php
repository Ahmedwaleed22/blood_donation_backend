<?php

namespace App\Http\Controllers;

use App\Models\CriticalCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function getNotifications() {
        $user = User::with('volunteer')->find(Auth::user()->id);
        $bloodType = $user->volunteer->blood_type;

        return CriticalCase::with('user')->where('blood_type', $bloodType)->get();
    }
}
