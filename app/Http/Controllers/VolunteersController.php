<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Volunteer|Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Volunteer::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'age' => 'string|required',
            'location' => 'string|required',
            'phone_number' => 'string|required',
            'is_smoking' => 'boolean|required',
            'blood_type' => 'string|required',
            'health_problems' => 'string|nullable',
            'health_condition' => 'string|required'
        ]);

        $volunteerWithSameId = Volunteer::all()->where('user_id', auth()->user()->id)->first();

        if (empty($volunteerWithSameId)) {
            $volunteer = new Volunteer();
            $volunteer->full_name = $request->name;
            $volunteer->age = $request->age;
            $volunteer->blood_type = $request->blood_type;
            $volunteer->location = $request->location;
            $volunteer->phone_number = $request->phone_number;
            $volunteer->is_smoking = $request->is_smoking;
            $volunteer->health_problems = $request->health_problems;
            $volunteer->health_condition = $request->health_condition;
            $volunteer->user_id = auth()->user()->id;
            $volunteer->save();

            return response()->json($volunteer);
        }

        return response()->json([
            'error' => 'You already have a volunteer account!'
        ], 500);
    }
}
