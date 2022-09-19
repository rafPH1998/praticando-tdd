<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        request()->validate([
            'columns' => ['nullable'], 
        ]);
        
        $user = User::all();

        return UserResource::collection($user);
    }
}
