<?php

namespace App\Entities\Laravel;

use App\EntityRepositories\Laravel\CacheRepository;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: CacheRepository::class)]
#[\Doctrine\ORM\Mapping\Table(name: 'cache')]
class Cache
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\Column(type: 'string')]
    protected string $key;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: false)]
    private string $value;

    #[\Doctrine\ORM\Mapping\Column(type: 'integer', nullable: false)]
    private string $expiration;

    public function __construct(string $key, string $value, string $expiration)
    {
        $this->key = $key;
        $this->value = $value;
        $this->expiration = $expiration;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): Cache
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): Cache
    {
        $this->value = $value;

        return $this;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    public function setExpiration(string $expiration): Cache
    {
        $this->expiration = $expiration;

        return $this;
    }
}
