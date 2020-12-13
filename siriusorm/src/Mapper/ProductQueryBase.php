<?php

declare(strict_types=1);

namespace app\Mapper;

use Sirius\Orm\Collection\Collection;
use Sirius\Orm\Collection\PaginatedCollection;
use Sirius\Orm\Query;
use app\Entity\Product;

abstract class ProductQueryBase extends Query
{
    public function first(): ?Product
    {
        return parent::first();
    }

    /**
     * @return Collection|Product[]
     */
    public function get(): Collection
    {
        return parent::get();
    }

    /**
     * @return PaginatedCollection|Product[]
     */
    public function paginate(int $perPage, int $page = 1): PaginatedCollection
    {
        return parent::paginate($perPage, $page);
    }
}
