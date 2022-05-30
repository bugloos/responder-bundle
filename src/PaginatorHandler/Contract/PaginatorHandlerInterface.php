<?php

namespace Bugloos\ResponderBundle\PaginatorHandler\Contract;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
interface PaginatorHandlerInterface
{
    public function initializePaginatorHandler($query, ?int $limit, array $options = []): void;

    public function setItemsPerPage(int $itemPerPage): void;

    public function setCurrentPage(int $page): void;

    public function getCurrentPageResults(): iterable;

    public function totalPages(): int;

    public function totalItems(): int;

    public function count(): int;

    public function numberOfItemsPerPage(): int;
}
