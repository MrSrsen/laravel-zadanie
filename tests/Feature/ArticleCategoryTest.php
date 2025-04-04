<?php

namespace Tests\Feature;

use App\Entities\ArticleCategory;
use App\EntityRepositories\ArticleCategoryRepository;
use Database\Fixtures\ArticleCategoryFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runFixturesOnce();
    }

    public function testAuthenticatedList(): void
    {
        $this
            ->getJson('/api/article-categories')
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testAuthenticatedShow(): ArticleCategory
    {
        /** @var ArticleCategoryRepository $categoryRepository */
        $categoryRepository = $this->app->get(EntityManagerInterface::class)->getRepository(ArticleCategory::class);
        $technology = $categoryRepository->findOneBy(['title' => ArticleCategoryFixtures::TECHNOLOGY]);

        $this
            ->getJson('/api/article-categories/'.$technology->getId())
            ->assertStatus(403)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        return $technology;
    }

    /** @depends testAuthenticatedShow */
    public function testShow(ArticleCategory $category): string
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $this
            ->getJson('/api/article-categories/'.$category->getId())
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Technology',
            ]);

        return $token;
    }

    /** @depends testShow */
    public function testList(string $token): void
    {
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
