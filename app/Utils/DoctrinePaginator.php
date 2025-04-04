<?php

namespace App\Utils;

use App\DataObject\PaginatorResult;
use Doctrine\ORM\Query;

class DoctrinePaginator
{
    private Query $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function paginate(int $page, int $items): PaginatorResult
    {
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->query);
        $paginator
            ->getQuery()
            ->setFirstResult($items * ($page - 1))
            ->setMaxResults($items);

        $totalItems = $paginator->count();

        return new PaginatorResult(
            totalItems: $totalItems,
            page: $page,
            maxPages: ceil($totalItems / $items),
            items: iterator_to_array($paginator->getIterator()),
        );
    }
}
