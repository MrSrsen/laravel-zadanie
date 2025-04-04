<?php

namespace App\Entities\Laravel;

use App\EntityRepositories\Laravel\CacheLockRepository;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: CacheLockRepository::class)]
#[\Doctrine\ORM\Mapping\Table(name: 'cache_locks')]
class CacheLock
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\Column(type: 'string')]
    protected string $key;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $owner;

    #[\Doctrine\ORM\Mapping\Column(type: 'integer', nullable: false)]
    private string $expiration;

    public function __construct(string $key, string $owner, string $expiration)
    {
        $this->key = $key;
        $this->owner = $owner;
        $this->expiration = $expiration;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): CacheLock
    {
        $this->key = $key;

        return $this;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): CacheLock
    {
        $this->owner = $owner;

        return $this;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    public function setExpiration(string $expiration): CacheLock
    {
        $this->expiration = $expiration;

        return $this;
    }
}
