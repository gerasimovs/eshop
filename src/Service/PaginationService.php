<?php

namespace App\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    /**
     * @param QueryBuilder|Query $query
     * @param Request $request
     * @param int $limit
     * @return Paginator
     */
    public function paginate($query, Request $request, int $limit): Paginator
    {
        $currentPage = $request->query->getInt('page') ?: 1;
        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($currentPage - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function lastPage(Paginator $paginator): int
    {
        return ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
    }

    /**
     * @param Paginator $paginator
     * @return int
     */
    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }
}
