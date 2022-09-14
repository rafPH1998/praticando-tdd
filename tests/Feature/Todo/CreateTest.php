<?php

namespace Tests\Feature\Todo;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_to_create_a_todo_item()
    {
        // arrange
        $user = User::factory()->createOne();
        $assignedTo = User::factory()->createOne();

        $this->actingAs($user);
        //action

        $request = $this->post(route('todo.store'), [
            'title'          => 'titulo qualquer',
            'description'    => 'descrição qualquer',
            'assigned_to_id' => $assignedTo->id,
        ]);

        //assert
        $request->assertRedirect(route('todo.index'));

        $this->assertDatabaseHas('todos', [
            'title'          => 'titulo qualquer',
            'description'    => 'descrição qualquer',
            'assigned_to_id' => $assignedTo->id,
        ]);
    }

    // public function test_should_be_able_add_a_file_to_the_todo_item()
    // {
    //     Storage::fake('s3');
    //     // arrange
    //     $user = User::factory()->createOne();

    //     $this->actingAs($user);
    //     //action

    //     $request = $this->post(route('todo.store'), [
    //         'title'          => 'titulo qualquer',
    //         'description'    => 'descrição qualquer',
    //         'assigned_to_id' => $user->id,
    //         'file'           => UploadedFile::fake()->image('image1.png')
    //     ]);

    //     //assert
    //     Storage::disk('s3')->assertExists('todo/image1.png');

    //     // $this->assertDatabaseHas('todos', [
    //     //     'file' => 'todo/image1.png'
    //     // ]);
    // }
}
