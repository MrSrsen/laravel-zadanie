<?php

namespace Tests\Feature;

use App\Entities\Subscriber;
use App\EntityRepositories\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->runFixturesOnce();
    }

    public function testShowingNotExisting(): void
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $this
            ->getJson('/api/subscribers/4db54dd4-5a06-49d3-bb3c-600a27874d58', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Subscriber not found.',
            ]);
    }

    public function testShow(): void
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        /** @var SubscriberRepository $subscriberRepository */
        $subscriberRepository = $this->app->get(EntityManagerInterface::class)->getRepository(Subscriber::class);
        $static = $subscriberRepository->findOneBy(['email' => 'static.subscriber@example.com']);

        $this
            ->getJson('/api/subscribers/'.$static->getId(), ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonFragment([
                'email' => 'static.subscriber@example.com',
                'firstName' => 'Static',
                'fullName' => 'Static Subscriber',
                'lastName' => 'Subscriber',
                'updatedAt' => null,
            ]);
    }

    public function testList(): void
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $response = $this
            ->getJson('/api/subscribers', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJsonStructure([
                'totalItems',
                'page',
                'maxPages',
                'items',
            ]);

        $subscriber = $response->json()['items'][0];
        $this->assertArrayHasKey('id', $subscriber);
        $this->assertArrayHasKey('fullName', $subscriber);
        $this->assertArrayHasKey('firstName', $subscriber);
        $this->assertArrayHasKey('lastName', $subscriber);
        $this->assertArrayHasKey('email', $subscriber);
        $this->assertArrayHasKey('createdAt', $subscriber);
        $this->assertArrayHasKey('updatedAt', $subscriber);
    }

    public function testFilter(): void
    {
        $token = $this->login('jozko.mrkvicka@example.sk', 'mrkvicka');

        $this
            ->getJson('/api/subscribers?email=static.', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(200)
            ->assertJson([
                'totalItems' => 1,
                'page' => 1,
                'maxPages' => 1,
                'items' => [
                    [
                        'fullName' => 'Static Subscriber',
                        'firstName' => 'Static',
                        'lastName' => 'Subscriber',
                        'email' => 'static.subscriber@example.com',
                        'updatedAt' => null,
                    ],
                ],
            ]);
    }
}
