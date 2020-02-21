<?php
declare(strict_types=1);

namespace ProductsTag;

use Atlas\Mapper\MapperRelationships;
use Product\Product;
use Tag\Tag;

class ProductsTagRelationships extends MapperRelationships
{
    protected function define()
    {
        // the threads side of the association mapping
        $this->manyToOne('products', Product::CLASS);

        // the tags side of the association mapping
        $this->manyToOne('tags', Tag::CLASS);
    }
}
