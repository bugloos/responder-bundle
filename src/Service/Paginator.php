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

    private ?int $limit = null;

    private Request $request;

    private $customResultDecorator;

    private PaginatorHandlerInterface $paginatorHandler;

    public function __construct(
        PaginatorHandlerInterface $paginatorHandler,
        int $defaultMaxItemsPerPage,
        int $defaultItemsPerPage
    ) {
        $this->paginatorHandler = $paginatorHandler;
        $this->defaultMaxItemsPerPage = $defaultMaxItemsPerPage;
        $this->defaultItemsPerPage = $defaultItemsPerPage;
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

    public function setCustomResultDecorator(callable $callable): self
    {
        $this->customResultDecorator = $callable;

        return $this;
    }

    /**
     * @param Query|QueryBuilder $query
     * @param array $options
     *
     * @return array
     */
    public function paginate($query, array $options = []): array
    {
        $this->paginatorHandler->initializePaginatorHandler($query, $this->limit, $options);

        $this->applyRequestOnPaginatorHandler();

        if ($this->hasCustomResultDecorator()) {
            return call_user_func($this->customResultDecorator, $this->paginatorHandler);
        }

        return $this->getResult();
    }

    private function hasCustomResultDecorator(): bool
    {
        return is_callable($this->customResultDecorator);
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

    private function getRequestedPageNumber(): int
    {
        return (int) $this->request->query->get('page', 1);
    }

    private function collection()
    {
        return $this->getRequestedPageNumber() <= $this->paginatorHandler->totalPages() ?
            $this->paginatorHandler->getCurrentPageResults() : [];
    }

    private function getRequestedItemPerPage(): int
    {
        return (int) $this->request->query->get('itemsPerPage', $this->defaultItemsPerPage);
    }

    private function getResult(): array
    {
        $count = $this->getRequestedPageNumber() <= $this->paginatorHandler->totalPages() ?
            $this->paginatorHandler->count() : 0;

        return [
            'pagination' => [
                'totalPages' => $this->paginatorHandler->totalPages(),
                'totalItems' => $this->paginatorHandler->totalItems(),
                'count' => $count,
                'itemsPerPage' => $this->paginatorHandler->numberOfItemsPerPage(),
                'page' => $this->getRequestedPageNumber(),
            ],
            'data' => $this->collection(),
        ];
    }
}
