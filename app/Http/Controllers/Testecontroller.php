<?php

namespace App\Http\Controllers;

use App\Http\Requests\TesteRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class Testecontroller extends Controller
{
    public function index()
    {
        return view('teste');
    }

    public function store(TesteRequest $request, Book $todo)
    {

        $todo->fill([
            'cnpj' => $request->get('cnpj')
        ]);

        $todo->save();

        return redirect()
            ->route('teste.store')
            ->with('success', 'CNPJ salvo com sucesso!');
    }
}
