<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_be_able_to_register_as_a_new_user()
    {

        // Act => Ação
        $return = $this->post(route('register'), [
            'name' => 'Rafael Silva',
            'email' => 'rafaelb89.rb@gmail.com',
            'password' => '12345'
        ]);

        //Assert
        $return->assertRedirect('home');

        $this->assertDatabaseHas('users', [
            'name' => 'Rafael Silva',
            'email' => 'rafaelb89.rb@gmail.com'
        ]);

        //Act = Ação
        $user = User::whereEmail('rafaelb89.rb@gmail.com')->firstOrFail();

        $this->assertTrue(
            Hash::check('12345', $user->password),
            'checando se a senha foi critografada'
        );
    }

    public function test_name_should_have_a_max_of_255_characters()
    {
        $this->post(route('register'), [
            'name' => str_repeat('a', 300)
        ])
        ->assertSessionHasErrors([
            'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
        ]);
    }

    public function test_name_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'name' => __('validation.required', ['attribute' => 'name']),
        ]);
    }

    // public function test_email_should_be_required()
    // {
        
    // }

    // public function test_email_should_be_a_valid_email()
    // {
        
    // }

    // public function test_email_should_be_unique()
    // {
        
    // }
}
