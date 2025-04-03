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
        $this
            ->postJson('/api/login')
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
        $this
            ->postJson('/api/login', [
                'login' => 'aaa',
                'password' => 'aaa',
            ])
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
        $this
            ->postJson('/api/login', [
                'login' => 'non.existing.user@example.com',
                'password' => 'pass_123',
            ])
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function testInvalidPassword(): void
    {
        $this
            ->postJson('/api/login', [
                'login' => 'jozko.mrkvicka@example.sk',
                'password' => 'pass_123',
            ])
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function testMeUnauthenticated(): void
    {
        $this
            ->getJson('/api/me')
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testSuccessfulLogin(): string
    {
        $response = $this
            ->postJson('/api/login', [
                'login' => 'jozko.mrkvicka@example.sk',
                'password' => 'mrkvicka',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
            ])
            ->assertJsonFragment([
                'token_type' => 'bearer',
                'expires_in' => 3600,
            ]);

        return $response->json('access_token');
    }

    /** @depends testSuccessfulLogin */
    public function testMe(string $token): void
    {
        $this
            ->getJson('/api/me', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonFragment([
                'email' => 'jozko.mrkvicka@example.sk',
                'title' => 'Jožko Mrkvička',
            ]);
    }

    /** @depends testSuccessfulLogin */
    public function testLogout(string $token): void
    {
        $this
            ->postJson('/api/logout', [], ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }
}
