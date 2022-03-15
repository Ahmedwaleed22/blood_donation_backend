<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'full_name' => 'string|required',
            'email' => 'email|required',
            'message' => 'string|required'
        ]);

        $contact = new Contact();
        $contact->full_name = $request->full_name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return response()->json($contact);
    }
}
