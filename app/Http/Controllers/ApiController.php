<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Team;
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

    public function teste()
    {
       $user = User::first();      
    
       $test = $user->teams;

       return response()->json($test);
    }

    public function teste2()
    {

        $team = Team::all();      

        //$a = $team->users;

        return response()->json($team);
    }
}
