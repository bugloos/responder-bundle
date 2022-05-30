<?php

namespace Bugloos\ResponderBundle\PaginatorHandler\Pagerfanta;

use Pagerfanta\Doctrine\ORM\QueryAdapter;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class CustomQueryAdapter extends QueryAdapter
{
    private ?int $limit = null;

    public function getNbResults(): int
    {
        if ($this->getLimit() !== null && parent::getNbResults() > $this->getLimit()) {
            return $this->getLimit();
        }

        return parent::getNbResults();
    }

    public function setLimit(?int $limit)
    {
        $this->limit = $limit;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
