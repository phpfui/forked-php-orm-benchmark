<?php

declare(strict_types=1);

namespace app\Mapper;

use Sirius\Orm\Collection\Collection;
use Sirius\Orm\Collection\PaginatedCollection;
use Sirius\Orm\Query;
use app\Entity\Tag;

abstract class TagQueryBase extends Query
{
    public function first(): ?Tag
    {
        return parent::first();
    }

    /**
     * @return Collection|Tag[]
     */
    public function get(): Collection
    {
        return parent::get();
    }

    /**
     * @return PaginatedCollection|Tag[]
     */
    public function paginate(int $perPage, int $page = 1): PaginatedCollection
    {
        return parent::paginate($perPage, $page);
    }
}
