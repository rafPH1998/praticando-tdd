<?php

namespace Tests\Feature\Api;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class BooksControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_books_get_endpoint()
    {
        $books = Book::factory(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use ($books) {

            $json->whereAllType([
                '0.id'    => 'integer',
                '0.title' => 'string',
                '0.isbn'  => 'string'
            ]);

            $book = $books->first();

            $json->whereAll([
                '0.id'    => $book->id,
                '0.title' => $book->title,
                '0.isbn'  => $book->isbn
            ]);
        });
    }

    public function test_get_single_book_endpoint()
    {
        $book = Book::factory(1)->createOne();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($book) {

            $json->hasAll(['id', 'title', 'isbn'])->etc();

            $json->whereAllType([
                'id'    => 'integer',
                'title' => 'string',
                'isbn'  => 'string'
            ]);

            $json->whereAll([
                'id'    => $book->id,
                'title' => $book->title,
                'isbn'  => $book->isbn
            ]);
        });
    }
}
