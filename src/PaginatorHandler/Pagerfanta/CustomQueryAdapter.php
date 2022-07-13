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

    public function getSlice($offset, $length): iterable
    {
        if ($this->existsMoreItemsThanLimitation($offset, $length)) {
            $length = $this->getNbResults() - $offset;
        }

        return parent::getSlice($offset, $length);
    }

    private function existsMoreItemsThanLimitation(int $offset, int $length): bool
    {
        return $this->getNbResults() < $offset + $length;
    }
}
