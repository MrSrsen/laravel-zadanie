<?php

namespace Tests\Feature;

use App\Entities\ArticleCategory;
use App\EntityRepositories\ArticleRepository;
use Database\Fixtures\ArticleCategoryFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runFixturesOnce();
    }

    public function testIndexAsUnauthenticated()
    {
        $this->getJson('/api/articles')
            ->assertStatus(403)
            ->assertJsonFragment([
                'Unauthenticated.',
            ]);
    }

    public function testIndex(): string
    {
        $token = $this->login('tech.bro@example.com', 'pass123');

        $response = $this->getJson('/api/articles?items=3', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'totalItems',
                'page',
                'maxPages',
                'items',
            ]);

        $article = $response->json()['items'][0];

        $this->assertArrayHasKey('id', $article);
        $this->assertArrayHasKey('title', $article);
        $this->assertArrayHasKey('subtitle', $article);
        $this->assertArrayHasKey('summary', $article);
        $this->assertArrayHasKey('content', $article);
        $this->assertArrayHasKey('category', $article);
        $this->assertArrayHasKey('publishedAt', $article);
        $this->assertArrayHasKey('createdAt', $article);

        return $token;
    }

    /** @depends testIndex */
    public function testCreateInUnassignedCategory(string $token): array
    {
        /** @var ArticleRepository $categoryRepository */
        $categoryRepository = $this->app->get(EntityManagerInterface::class)->getRepository(ArticleCategory::class);
        $food = $categoryRepository->findOneBy(['title' => ArticleCategoryFixtures::FOOD]);

        $article = [
            'title' => 'Best food of 2025',
            'subtitle' => 'You won\'t believe it what\'s out there!',
            'content' => 'Bla bla bla... Sponsored content...',
            'category' => $food->getId(),
        ];

        $response = $this->postJson('/api/articles', $article, ['Authorization' => 'Bearer '.$token])
            ->assertStatus(400)
            ->assertJsonFragment([
                'message' => 'Cannot create Article in unassigned ArticleCategory.',
            ]);

        return [$token, $response->json()];
    }

    /** @depends testIndex */
    public function testCreate(string $token): array
    {
        /** @var ArticleRepository $categoryRepository */
        $categoryRepository = $this->app->get(EntityManagerInterface::class)->getRepository(ArticleCategory::class);
        $food = $categoryRepository->findOneBy(['title' => ArticleCategoryFixtures::TECHNOLOGY]);

        $article = [
            'title' => 'Best food of 2025',
            'subtitle' => 'You won\'t believe it what\'s out there!',
            'content' => 'Bla bla bla... Sponsored content...',
            'category' => $food->getId(),
        ];

        $response = $this->postJson('/api/articles', $article, ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonFragment($article);

        return [$token, $response->json()];
    }

    /** @depends testCreate */
    public function testShowToAnotherAuthor(array $tokenArticlePair): void
    {
        list($_, $article) = $tokenArticlePair;

        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $this->getJson('/api/articles/'.$article['id'], ['Authorization' => 'Bearer '.$token])
            ->assertStatus(403)
            ->assertJsonFragment([
                'message' => 'Cannot view article. Only authors can view articles.',
            ]);
    }

    /** @depends testCreate */
    public function testUpdate(array $tokenArticlePair): array
    {
        list($token, $article) = $tokenArticlePair;

        /** @var ArticleRepository $articleRepository */
        $articleRepository = $this->app->get(EntityManagerInterface::class)->getRepository(ArticleCategory::class);
        $technology = $articleRepository->findOneBy(['title' => ArticleCategoryFixtures::TECHNOLOGY]);

        $article['title'] = 'New title';
        $article['subtitle'] = 'New subtitle';
        $article['content'] = 'New content';
        $article['category'] = $technology->getId();
        unset($article['updatedAt']); // will change

        $response = $this
            ->putJson('/api/articles/'.$article['id'], $article, ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson($article);

        return [$token, $response->json()];
    }

    /** @depends testUpdate */
    public function testDelete(array $tokenArticlePair): array
    {
        list($token, $article) = $tokenArticlePair;

        $this->delete('/api/articles/'.$article['id'], [], ['Authorization' => 'Bearer '.$token])
            ->assertStatus(204);

        return [$token, $article];
    }

    /** @depends testDelete */
    public function testShowDeleted(array $tokenArticlePair): void
    {
        list($token, $article) = $tokenArticlePair;

        $this->getJson('/api/articles/'.$article['id'], ['Authorization' => 'Bearer '.$token])
            ->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Article not found.',
            ]);
    }
}
