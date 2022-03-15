<?php

namespace App\Http\Controllers;

use App\Models\CriticalCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CriticalCasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'string|required',
            'age' => 'string|required',
            'location' => 'string|required',
            'blood_type' => 'string|required',
            'level' => 'string|required',
            'file' => 'mimes:pdf,png,jpg,jpeg'
        ]);

        $criticalCase = new CriticalCase();
        $criticalCase->name = $request->name;
        $criticalCase->age = $request->age;
        $criticalCase->location = $request->location;
        $criticalCase->blood_type = $request->blood_type;
        $criticalCase->level = $request->level;

        if ($file = $request->file('file')) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/', $filename);

            $criticalCase->file = "uploads/" . $filename;
        } else {
            $criticalCase->file = null;
        }

        $criticalCase->user_id = auth()->user()->id;
        $criticalCase->save();
        return response()->json($criticalCase);
    }
}
