<?php

namespace App\EntityRepositories;

use App\Entities\Subscriber;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Subscriber> */
class SubscriberRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    public function getAllSubscribersQuery(?string $firstName = null, ?string $lastName = null, ?string $email = null): \Doctrine\ORM\Query
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.deletedAt IS NULL');

        if (!empty($firstName)) {
            $qb
                ->andWhere('s.firstName LIKE :firstName')
                ->setParameter('firstName', '%'.$firstName.'%');
        }

        if (!empty($lastName)) {
            $qb
                ->andWhere('s.lastName LIKE :lastName')
                ->setParameter('lastName', '%'.$lastName.'%');
        }

        if (!empty($email)) {
            $qb
                ->andWhere('s.email LIKE :email')
                ->setParameter('email', '%'.$email.'%');
        }

        return $qb->getQuery();
    }
}
