<?php

namespace App\EntityRepositories;

use App\Entities\Article;
use App\Entities\Blogger;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\App;

/** @extends EntityRepository<Article> */
class ArticleRepository extends EntityRepository
{
    public static function make(): self
    {
        return App::make(self::class);
    }

    public function getBloggersArticlesQuery(Blogger $blogger): Query
    {
        return $this->createQueryBuilder('a')
            ->where('a.blogger = :blogger')
            ->andWhere('a.deletedAt IS NULL')
            ->setParameter('blogger', $blogger)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();
    }

    /** @return array<Article> */
    public function findForSending(): array
    {
        return $this->createQueryBuilder('a')
            ->addSelect('b')
            ->addSelect('c')
            ->leftJoin('a.blogger', 'b')
            ->leftJoin('a.category', 'c')
            ->where('a.deletedAt IS NULL')
            ->andWhere('a.publishedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}
