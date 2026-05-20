<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Storage::fake('public');

        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'verification_document' => UploadedFile::fake()->create('diploma.pdf', 100, 'application/pdf'),
            'privacy' => '1',
        ]);

        $this->assertAuthenticated();
        // New accounts start as pending and are sent to the waiting-for-approval page.
        $response->assertRedirect(route('pending'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'alumni',
            'status' => 'pending',
        ]);
    }
}
