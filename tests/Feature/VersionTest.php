<?php

namespace Tests\Feature;

use Tests\TestCase;

class VersionTest extends TestCase
{
    public function testVersion(): void
    {
        $this->get('/api/version')
            ->assertStatus(200)
            ->assertJson([
                'name' => 'laravel/laravel',
                'version' => '1.0.0.0',
            ]);
    }
}
