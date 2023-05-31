<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Operators;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    

  
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $operator = Operators::where('email', $credentials['email'])->first();
    
        if ($operator && Hash::check($credentials['password'], $operator->password)) {
            
            return response()->json([
                "success" => true,
                'message' => "Successfully loged in",
                "data" => $operator
            ]);
        } else {
            return response()->json([
                "success" => false,
                'message' => "Wrong email or password",
            ]);
        }
    }
}
