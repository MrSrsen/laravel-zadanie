<?php

namespace App\EntityRepositories;

use App\Entities\Article;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Article> */
class ArticleRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }
}
