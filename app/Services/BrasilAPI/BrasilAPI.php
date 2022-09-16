<?php

namespace App\Services\BrasilAPI;

use App\Services\BrasilAPI\Entities\CPNJ;
use App\Services\BrasilAPI\Exceptions\CPNJNotFound;
use Illuminate\Support\Facades\Http;

/**
 * 
 * Documentation of Brasil API: https://brasilapi.com.br/docs
 */

class BrasilAPI
{

    public function cpnj(string $cpnj): CPNJ
    {
        $request = Http::get('https://brasilapi.com.br/api/cnpj/v1/'. $cpnj);
        
        if ($request->status() !== 200) {
            throw new CPNJNotFound("Error Processing Request", 1);
        }
        
        return new CPNJ($request->json());
    }




}