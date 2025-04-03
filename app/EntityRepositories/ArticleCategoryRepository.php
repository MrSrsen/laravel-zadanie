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

    /** @return array<Article> */
    public function findAllSorted(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.title', 'ASC')
            ->where('a.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}
