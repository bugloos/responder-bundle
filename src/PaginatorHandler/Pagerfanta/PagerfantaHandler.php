<?php

namespace Bugloos\ResponderBundle\PaginatorHandler\Pagerfanta;

use Bugloos\ResponderBundle\PaginatorHandler\Contract\PaginatorHandlerInterface;
use Pagerfanta\Pagerfanta;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class PagerfantaHandler implements PaginatorHandlerInterface
{
    private const FETCH_JOIN_COLLECTION = 'fetchJoinCollection';

    private Pagerfanta $paginatorHandler;

    public function initializePaginatorHandler($query, int $limit = null, array $options = []): void
    {
        $fetchJoinCollection = true;

        if (
            array_key_exists(self::FETCH_JOIN_COLLECTION, $options) &&
            $options['fetchJoinCollection'] === false
        ) {
            $fetchJoinCollection = false;
        }

        $adapter = new CustomQueryAdapter($query, $fetchJoinCollection);

        if ($limit !== null) {
            $adapter->setLimit($limit);
        }

        $this->paginatorHandler = new Pagerfanta($adapter);
    }

    public function getCurrentPageResults(): iterable
    {
        return $this->paginatorHandler->getCurrentPageResults();
    }

    public function totalPages(): int
    {
        return $this->paginatorHandler->getNbPages();
    }

    public function totalItems(): int
    {
        return $this->paginatorHandler->getNbResults();
    }

    public function count(): int
    {
        return \count($this->paginatorHandler->getIterator());
    }

    public function numberOfItemsPerPage(): int
    {
        return $this->paginatorHandler->getMaxPerPage();
    }

    public function setItemsPerPage(int $itemPerPage): void
    {
        $this->paginatorHandler->setMaxPerPage($itemPerPage);
    }

    public function setCurrentPage(int $page): void
    {
        $this->paginatorHandler->setCurrentPage($page);
    }
}
