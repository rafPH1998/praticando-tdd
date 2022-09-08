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
        $book = Book::factory(1)->createOne(); //vai criar na base

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

    public function test_post_books_endpoint()
    {
        $book = Book::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/books', $book);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($book) {

            $json->hasAll(['id', 'title', 'isbn'])->etc();

            $json->whereAllType([
                'id'    => 'integer',
                'title' => 'string',
                'isbn'  => 'string'
            ]);

            $json->whereAll([
                'title' => $book['title'],
                'isbn'  => $book['isbn']
            ]);
        });
    }

    public function test_post_validation_when_try_create_a_invalid_book()
    {

        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['message', 'errors']);

            $json->where('errors.title.0', 'Campo obrigátório!')
                ->where('errors.isbn.0', 'Campo obrigátório!');
        });
    }

    public function test_put_book_endpoint()
    {
        Book::factory(1)->create();

        $book = [
            'title' => 'Atualizando livro',
            'isbn' => 'Salve teste',
        ];

        $response = $this->putJson('/api/books/1', $book);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($book) {

            $json->hasAll(['id', 'title', 'isbn'])->etc();

            $json->whereAllType([
                'id'    => 'integer',
                'title' => 'string',
                'isbn'  => 'string'
            ]);

            $json->whereAll([
                'title' => $book['title'],
                'isbn'  => $book['isbn']
            ]);
        });
    }

    public function test_delete_book_endpoint()
    {
        Book::factory(1)->create();

        $response = $this->deleteJson('/api/books/1');

        $response->assertStatus(204);
    }
}
