<?php

namespace App\Entities;

use App\Utils\UuidGenerator;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
trait EntityTrait
{
    #[\Doctrine\ORM\Mapping\Column(type: 'guid')]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'CUSTOM')]
    #[\Doctrine\ORM\Mapping\CustomIdGenerator(class: UuidGenerator::class)]
    #[\Doctrine\ORM\Mapping\Id]
    protected string $id;

    #[\Doctrine\ORM\Mapping\Column(type: 'datetime_immutable', nullable: false)]
    protected \DateTimeImmutable $createdAt;

    #[\Doctrine\ORM\Mapping\Column(type: 'datetime_immutable', nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    #[\Doctrine\ORM\Mapping\Column(type: 'datetime_immutable', nullable: true)]
    protected ?\DateTimeImmutable $deletedAt = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    #[\Doctrine\ORM\Mapping\PrePersist]
    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->setCreatedAt(now()->toDateTimeImmutable());
    }

    #[\Doctrine\ORM\Mapping\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->setUpdatedAt(now()->toDateTimeImmutable());
    }
}
