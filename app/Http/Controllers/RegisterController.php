<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);
        
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        User::create($data);
    
        return redirect()->route('home');
    }
}
