<?php

namespace App\EntityRepositories;

use App\Entities\Article;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Article> */
class ArticleCategoryRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    public function getAllSortedQuery(): \Doctrine\ORM\Query
    {
        return $this->createQueryBuilder('a')
            ->where('a.deletedAt IS NULL')
            ->orderBy('a.title', 'ASC')
            ->getQuery();
    }
}
