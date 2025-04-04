<?php

namespace App\EntityRepositories\Laravel;

use App\Entities\Laravel\FailedJob;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<FailedJob> */
class FailedJobRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }
}
