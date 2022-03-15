<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CriticalCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CriticalCasesManagement extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'isAdmin']);
    }

    public function index() {
        return CriticalCase::with('user')->get();
    }

    public function show($id) {
        return CriticalCase::with('user')->find($id);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'id' => 'numeric',
            'name' => 'string',
            'age' => 'string',
            'location' => 'string',
            'blood_type' => 'string',
            'level' => 'string',
            'file' => 'mimes:pdf,png,jpg,jpeg'
        ]);

        $criticalCase = CriticalCase::query()->findOrFail($id);
        $criticalCase->name = $request->name ?? $criticalCase->name;
        $criticalCase->age = $request->age ?? $criticalCase->age;
        $criticalCase->location = $request->location ?? $criticalCase->location;
        $criticalCase->blood_type = $request->blood_type ?? $criticalCase->blood_type;
        $criticalCase->level = $request->level ?? $criticalCase->level;

        if ($file = $request->file('file')) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/', $filename);

            $criticalCase->file = "uploads/" . $filename;
        }

        $criticalCase->save();
        return response()->json($criticalCase);
    }

    public function delete($id): JsonResponse
    {
        if (CriticalCase::all()->find($id)->delete()) {
            return response()->json([
                'message' => 'Critical Case Deleted Successfully!'
            ]);
        } else {
            return response()->json([
                'message' => 'Couldn\'t Delete Critical Case!'
            ]);
        }
    }
}
