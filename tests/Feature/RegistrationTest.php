<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test',
            'surname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'phone' => '+12345678901',
            'password' => 'Password1!',
            'password_confirmation' => 'Password1!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);
        $this->assertAuthenticated();
    }
}
