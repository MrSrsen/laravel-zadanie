<?php

namespace App\Entities;

use App\EntityRepositories\SubscriberRepository;
use Webmozart\Assert\Assert;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: SubscriberRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class Subscriber
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $firstName;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $lastName;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    public function __construct(string $firstName, string $lastName, string $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Subscriber
    {
        Assert::maxLength($firstName, 255);
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Subscriber
    {
        Assert::maxLength($lastName, 255);
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Subscriber
    {
        Assert::maxLength($email, 255);
        $this->email = $email;

        return $this;
    }
}
