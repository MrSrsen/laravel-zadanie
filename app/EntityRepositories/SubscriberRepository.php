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
}
