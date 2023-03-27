<?php

namespace Bugloos\ResponderBundle\Service;

use Bugloos\ResponderBundle\PaginatorHandler\Contract\PaginatorHandlerInterface;

interface PaginatorResponseInterface
{
    public function getResult(PaginatorHandlerInterface $paginatorHandler, Paginator $paginator): array;
}
