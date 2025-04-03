<?php

namespace App\EntityRepositories;

use App\Entities\Blogger;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Blogger> */
class BloggerRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }
}
