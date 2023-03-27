<?php

namespace Bugloos\ResponderBundle\Service;

use Bugloos\ResponderBundle\PaginatorHandler\Contract\PaginatorHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class Paginator
{
    private int $defaultMaxItemsPerPage;

    private int $defaultItemsPerPage;

    private string $pageKeyInRequest;

    private string $itemsPerPageKeyInRequest;

    private ?int $limit = null;

    private Request $request;

    private PaginatorHandlerInterface $paginatorHandler;

    private PaginatorResponseInterface $paginatorResponse;

    public function __construct(
        PaginatorHandlerInterface $paginatorHandler,
        PaginatorResponseInterface $paginatorResponse,
        int $defaultMaxItemsPerPage,
        int $defaultItemsPerPage,
        string $pageKeyInRequest,
        string $itemsPerPageKeyInRequest
    ) {
        $this->paginatorHandler = $paginatorHandler;
        $this->paginatorResponse = $paginatorResponse;
        $this->defaultMaxItemsPerPage = $defaultMaxItemsPerPage;
        $this->defaultItemsPerPage = $defaultItemsPerPage;
        $this->pageKeyInRequest = $pageKeyInRequest;
        $this->itemsPerPageKeyInRequest = $itemsPerPageKeyInRequest;
    }

    public function for(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setDefaultItemPerPage(int $perPage): self
    {
        $this->defaultItemsPerPage = $perPage;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function paginate(object $query, array $options = []): iterable
    {
        $this->paginatorHandler->initializePaginatorHandler($query, $this->limit, $options);

        $this->applyRequestOnPaginatorHandler();

        return $this->paginationResponse->getResult($this->paginatorHandler, $this);
    }

    public function getRequestedPageNumber(): int
    {
        return (int) $this->request->query->get($this->pageKeyInRequest, 1);
    }

    public function collection(): iterable
    {
        return $this->getRequestedPageNumber() <= $this->paginatorHandler->totalPages() ?
            $this->paginatorHandler->getCurrentPageResults() : [];
    }

    public function getRequestedItemPerPage(): int
    {
        return (int) $this->request->query->get($this->itemsPerPageKeyInRequest, $this->defaultItemsPerPage);
    }

    public function count(): int
    {
        return $this->getRequestedPageNumber() <= $this->paginatorHandler->totalPages() ?
            $this->paginatorHandler->count() : 0;
    }

    private function getNormalizedItemsPerPage(): int
    {
        return $this->getRequestedItemPerPage() > $this->defaultMaxItemsPerPage ?
            $this->defaultMaxItemsPerPage : $this->getRequestedItemPerPage();
    }

    private function applyRequestOnPaginatorHandler(): void
    {
        $this->paginatorHandler->setItemsPerPage($this->getNormalizedItemsPerPage());

        if ($this->getRequestedPageNumber() <= $this->paginatorHandler->totalPages()) {
            $this->paginatorHandler->setCurrentPage($this->getRequestedPageNumber());
        }
    }
}
