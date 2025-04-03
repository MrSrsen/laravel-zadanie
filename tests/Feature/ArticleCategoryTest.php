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

    public function testIndex(): void
    {
        $this
            ->getJson('/api/article-categories')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
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
