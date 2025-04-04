<?php

namespace App\EntityRepositories\Laravel;

use App\Entities\Laravel\Cache;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Cache> */
class CacheRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }
}
