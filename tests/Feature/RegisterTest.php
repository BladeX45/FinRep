<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase; // reset DB tiap test

    public function test_user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'name' => 'Benidictus',
            'email' => 'benidictus@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated(); // pastikan user login
        $this->assertDatabaseHas('users', [
            'email' => 'benidictus@example.com',
        ]);
    }

    public function test_register_fails_with_invalid_data()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123',
            'password_confirmation' => '456',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest(); // pastikan belum login
    }
}
