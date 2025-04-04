<?php

namespace App\Entities\Laravel;

use App\EntityRepositories\Laravel\JobRepository;
use Symfony\Component\Uid\Uuid;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: JobRepository::class)]
#[\Doctrine\ORM\Mapping\Table(name: 'jobs')]
#[\Doctrine\ORM\Mapping\Index(fields: ['queue'], name: 'idx_queue')]
class Job
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'IDENTITY')]
    #[\Doctrine\ORM\Mapping\Column(type: 'integer')]
    protected string $id;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $queue;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $payload;

    #[\Doctrine\ORM\Mapping\Column(type: 'integer', nullable: false)]
    private int $attempts;

    #[\Doctrine\ORM\Mapping\Column(name: 'reserved_at', type: 'integer', nullable: true)]
    private ?int $reservedAt = null;

    #[\Doctrine\ORM\Mapping\Column(name: 'available_at', type: 'integer', nullable: false)]
    private int $availableAt;

    #[\Doctrine\ORM\Mapping\Column(name: 'created_at', type: 'integer', nullable: false)]
    private int $createdAt;

    public function __construct(string $queue, string $payload, int $attempts, ?int $reservedAt, int $availableAt, int $createdAt)
    {
        $this->id = Uuid::v4()->toRfc4122();

        $this->queue = $queue;
        $this->payload = $payload;
        $this->attempts = $attempts;
        $this->reservedAt = $reservedAt;
        $this->availableAt = $availableAt;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Job
    {
        $this->id = $id;

        return $this;
    }

    public function getQueue(): string
    {
        return $this->queue;
    }

    public function setQueue(string $queue): Job
    {
        $this->queue = $queue;

        return $this;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): Job
    {
        $this->payload = $payload;

        return $this;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts): Job
    {
        $this->attempts = $attempts;

        return $this;
    }

    public function getReservedAt(): ?int
    {
        return $this->reservedAt;
    }

    public function setReservedAt(?int $reservedAt): Job
    {
        $this->reservedAt = $reservedAt;

        return $this;
    }

    public function getAvailableAt(): int
    {
        return $this->availableAt;
    }

    public function setAvailableAt(int $availableAt): Job
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): Job
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
