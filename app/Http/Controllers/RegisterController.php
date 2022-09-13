<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:users', 'confirmed'],
            'password' => ['required', 'string', Password::min(4)->mixedCase()],
        ]);
        
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        User::create($data);
    
        return redirect()->route('home');
    }
}
