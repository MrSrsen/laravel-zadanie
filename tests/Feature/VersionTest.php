<?php

namespace Tests\Feature;

use Tests\TestCase;

class VersionTest extends TestCase
{
    public function testVersion(): void
    {
        $response = $this->get('/api/version');

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'laravel/laravel',
                'version' => '1.0.0.0',
            ]);
    }
}
