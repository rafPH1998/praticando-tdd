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
            'email_confirmation' => 'rafaelb89.rb@gmail.com',
            'password' => '12345aB'
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
            Hash::check('12345aB', $user->password),
            'checando se a senha foi critografada'
        );
    }

    public function test_name_should_have_a_max_of_20_characters()
    {
        $this->post(route('register'), [
            'name' => str_repeat('a', 30)
        ])
        ->assertSessionHasErrors([
            'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 20]),
        ]);
    }

    public function test_name_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'name' => __('validation.required', ['attribute' => 'name']),
        ]);
    }

    public function test_email_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'email' => __('validation.required', ['attribute' => 'email']),
        ]);
    }

    public function test_email_should_be_a_valid_email()
    {
        $this->post(route('register'), ['email' => 'dasdasdasadsm'])
            ->assertSessionHasErrors([
                'email' => __('validation.email', ['attribute' => 'email']),
            ]);
    }

    public function test_email_should_be_unique()
    {
        //arrange
        User::factory()->create(['email' => 'rafaelb89@gmail.com']);

        //action
        $this->post(route('register'), [
            'email' => 'rafaelb89@gmail.com'
        ])
        //assert
        ->assertSessionHasErrors([
            'email' => __('validation.unique', ['attribute' => 'email']),
        ]);
    }

    public function test_email_should_be_confirmed()
    {
        $this->post(route('register'), [
            'email'              => 'rafaelb89@gmail.com',
            'email_confirmation' => '',
        ])
        ->assertSessionHasErrors([
            'email' => __('validation.confirmed', ['attribute' => 'email']),
        ]);
    }


    public function test_password_have_at_least_1_uppercase()
    {
        $this->post(route('register', [
            'password' => 'password-without-uppercase'
        ]))
        ->assertSessionHasErrors([
            'password' => 'The password must contain at least one uppercase and one lowercase letter.'
        ]);
    }

     public function test_password_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'password' => __('validation.required', ['attribute' => 'password']),
        ]);
    }


}
