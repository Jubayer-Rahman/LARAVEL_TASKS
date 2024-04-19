<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index(){
        $user_id = Auth::id();
        $contacts = Contact::where('user_id', $user_id)->get();
        return response()->json([
            'message' => 'Request Succesfull',
            'data'=> $contacts
        ], status: 201);
    }
    public function store(Request $request){
        $request->validate([
            'number' => [
                'required',
                'string',
                Rule::unique('contacts', 'number'),
            ],
        ]);

        $user_id = Auth::id(); // Get the ID of the authenticated user
        if (!$user_id){
            return response()->json(['message' => 'User not found'], status:404);
        }
        Contact::create([
            'user_id' => $user_id,
            'number' => $request->number,
        ]);
        return response()->json(['message'=> 'Phone number added'], status:200);
    }
    public function destroy(Request $request)
    {
        $number = $request->number;
        $contact = Contact::where('number', $number)->first();
        if (!$contact){
            return response()->json(['message'=> 'Phone number not found'], status:404);
        }
        elseif ($contact->user_id === Auth::id()) {
            $contact->delete();
            return response()->json(['message'=> 'Phone number deletion successful'], status:200);
        } else {
            return response()->json(['message'=> 'Phone number doesnot belong to you'], status:404);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
        ]);

        $number = $request->number;
        $contact = Contact::where('number', $number)->first();
        if (!$contact){
            return response()->json(['message'=> 'Phone number not found'], status:404);
        }
        elseif ($contact->user_id === Auth::id()) {
            $contact->update([
                'number' => $request->number_new,
            ]);
            return response()->json(['message'=> 'Phone number updated successfully'], status:200);
        } else {
            return response()->json(['message'=> 'Phone number doesnot belong to you'], status:404);
        }
    }
}
