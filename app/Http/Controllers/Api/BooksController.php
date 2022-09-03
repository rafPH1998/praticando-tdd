<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct
    (
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
}
