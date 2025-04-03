<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runFixturesOnce();
    }

    public function testEmpty(): void
    {
        $response = $this->post('/api/login');

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'login' => [
                        'The login field is required.',
                    ],
                    'password' => [
                        'The password field is required.',
                    ],
                ],
            ]);
    }

    public function testInvalidData(): void
    {
        $response = $this->postJson('/api/login', [
            'login' => 'aaa',
            'password' => 'aaa',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'login' => [
                        'The login field must be a valid email address.',
                    ],
                    'password' => [
                        'The password field must be at least 6 characters.',
                    ],
                ],
            ]);
    }

    public function testNotExistingUser(): void
    {
        $response = $this->postJson('/api/login', [
            'login' => 'non.existing.user@example.com',
            'password' => 'pass_123',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function testInvalidPassword(): void
    {
        $response = $this->postJson('/api/login', [
            'login' => 'jozko.mrkvicka@example.sk',
            'password' => 'pass_123',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function testSuccessfulLogin(): void
    {
        $response = $this->postJson('/api/login', [
            'login' => 'jozko.mrkvicka@example.sk',
            'password' => 'mrkvicka',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ])
            ->assertJsonFragment([
                'token_type' => 'bearer',
                'expires_in' => 3600,
            ]);
    }
}
