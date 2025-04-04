<?php

namespace App\EntityRepositories\Laravel;

use App\Entities\Laravel\Job;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Job> */
class JobRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }
}
