<?php

declare(strict_types=1);

namespace app\Mapper;

use Sirius\Orm\Collection\Collection;
use Sirius\Orm\Collection\PaginatedCollection;
use Sirius\Orm\Query;
use app\Entity\Category;

abstract class CategoryQueryBase extends Query
{
    public function first(): ?Category
    {
        return parent::first();
    }

    /**
     * @return Collection|Category[]
     */
    public function get(): Collection
    {
        return parent::get();
    }

    /**
     * @return PaginatedCollection|Category[]
     */
    public function paginate(int $perPage, int $page = 1): PaginatedCollection
    {
        return parent::paginate($perPage, $page);
    }
}
