<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct (
        protected Book $book
    ) {}
    
    public function index()
    {
        return response()->json($this->book->all());
    }

    public function show($id)
    {
        $book = $this->book->find($id);
        return response()->json($book);
    }

    public function store(StoreBookRequest $r)
    {
        $book = $this->book->create($r->all());
        return response()->json($book, 201);
    }

    public function update($id, Request $r)
    {
        $book = $this->book->find($id);
        $book->update($r->all());
        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = $this->book->find($id);
        $book->delete();

        return response()->json([], 204);
    }
}
