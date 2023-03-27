<?php

namespace Bugloos\ResponderBundle\Service;

use Bugloos\ResponderBundle\PaginatorHandler\Contract\PaginatorHandlerInterface;
class DefaultPaginatorResponse implements PaginatorResponseInterface
{
    public function getResult(PaginatorHandlerInterface $paginatorHandler, Paginator $paginator): array
    {
        return [
            'pagination' => [
                'totalPages' => $paginatorHandler->totalPages(),
                'totalItems' => $paginatorHandler->totalItems(),
                'count' => $paginator->count(),
                'itemsPerPage' => $paginatorHandler->numberOfItemsPerPage(),
                'page' => $paginator->getRequestedPageNumber(),
            ],
            'data' => $paginator->collection(),
        ];
    }
}
