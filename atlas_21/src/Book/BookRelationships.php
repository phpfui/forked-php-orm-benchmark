<?php
declare(strict_types=1);

namespace Book;

use Atlas\Mapper\MapperRelationships;
use Author\Author;

class BookRelationships extends MapperRelationships
{
    protected function define()
    {
        $this->manyToOne('author', Author::CLASS);
    }
}
