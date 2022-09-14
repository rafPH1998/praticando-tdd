<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_be_able_to_updated_a_todo_item()
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        $todo = Todo::factory()->createOne();
        
        $this->actingAs($user);
        $this->put(route('todo.update', $todo), [
            'title'          => 'Updated aa',
            'description'    => 'Updated Todo Description',
            'assigned_to_id' => $user->id,
        ])->assertRedirect(route('todo.index'));

        $todo->refresh();

        $this->assertEquals('Updated aa', $todo->title);
        $this->assertEquals('Updated Todo Description', $todo->description);
    }
}
