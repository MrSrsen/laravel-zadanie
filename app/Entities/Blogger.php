<?php

namespace App\Entities;

use App\EntityRepositories\BloggerRepository;
use Tymon\JWTAuth\Contracts\JWTSubject;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: BloggerRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class Blogger implements JWTSubject, \Illuminate\Contracts\Auth\Authenticatable
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    public string $title;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', unique: true, nullable: false)]
    public string $email;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    public string $password;

    public function __construct(string $title, string $email, string $password)
    {
        $this->title = $title;
        $this->email = $email;
        $this->password = $password;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getAuthIdentifierName(): string
    {
        return 'email';
    }

    public function getAuthIdentifier(): ?string
    {
        return $this->getEmail();
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): string
    {
        return $this->getPassword();
    }

    public function getRememberToken()
    {
        throw new \RuntimeException('Not implemented.');
    }

    public function setRememberToken($value)
    {
        throw new \RuntimeException('Not implemented.');
    }

    public function getRememberTokenName()
    {
        throw new \RuntimeException('Not implemented.');
    }
}
