<?php

namespace App\Entities\Laravel;

use App\EntityRepositories\Laravel\FailedJobRepository;
use App\Utils\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: FailedJobRepository::class)]
#[\Doctrine\ORM\Mapping\Table(name: 'failed_jobs')]
class FailedJob
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'IDENTITY')]
    #[\Doctrine\ORM\Mapping\Column(type: 'integer')]
    private string $id;

    #[\Doctrine\ORM\Mapping\Column(type: 'guid', unique: true)]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'CUSTOM')]
    #[\Doctrine\ORM\Mapping\CustomIdGenerator(class: UuidGenerator::class)]
    private string $uuid;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $connection;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $queue;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $payload;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $exception;

    #[\Doctrine\ORM\Mapping\Column(name: 'failed_at', type: 'datetimetz', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private string $failedAt;

    public function __construct(string $connection, string $queue, string $payload, string $exception, ?string $failedAt = null)
    {
        $this->uuid = Uuid::v4()->toRfc4122();
        $this->connection = $connection;
        $this->queue = $queue;
        $this->payload = $payload;
        $this->exception = $exception;
        $this->failedAt = $failedAt ?? (new \DateTimeImmutable())->getTimestamp();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getConnection(): string
    {
        return $this->connection;
    }

    public function setConnection(string $connection): FailedJob
    {
        $this->connection = $connection;

        return $this;
    }

    public function getQueue(): string
    {
        return $this->queue;
    }

    public function setQueue(string $queue): FailedJob
    {
        $this->queue = $queue;

        return $this;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): FailedJob
    {
        $this->payload = $payload;

        return $this;
    }

    public function getException(): string
    {
        return $this->exception;
    }

    public function setException(string $exception): FailedJob
    {
        $this->exception = $exception;

        return $this;
    }

    public function getFailedAt(): string
    {
        return $this->failedAt;
    }

    public function setFailedAt(string $failedAt): FailedJob
    {
        $this->failedAt = $failedAt;

        return $this;
    }
}
