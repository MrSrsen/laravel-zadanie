<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runFixturesOnce();
    }

    public function testIndexAsUnauthenticated(): void
    {
        $this
            ->getJson('/api/article-categories')
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testIndex(): void
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $this
            ->getJson('/api/article-categories', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson([
                'totalItems' => 11,
                'page' => 1,
                'maxPages' => 1,
                'items' => [
                    [
                        'title' => 'Business',
                    ],
                    [
                        'title' => 'Entertainment',
                    ],
                    [
                        'title' => 'Fashion',
                    ],
                    [
                        'title' => 'Finance',
                    ],
                    [
                        'title' => 'Food',
                    ],
                    [
                        'title' => 'History',
                    ],
                    [
                        'title' => 'Lifestyle',
                    ],
                    [
                        'title' => 'Politics',
                    ],
                    [
                        'title' => 'Sports',
                    ],
                    [
                        'title' => 'Technology',
                    ],
                    [
                        'title' => 'Travel',
                    ],
                ],
            ]);
    }
}
