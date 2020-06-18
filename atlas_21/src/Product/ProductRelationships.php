<?php
declare(strict_types=1);

namespace Product;

use Atlas\Mapper\MapperRelationships;
use Category\Category;
use Image\Image;
use ProductsTag\ProductsTag;
use Tag\Tag;

class ProductRelationships extends MapperRelationships
{
    protected function define()
    {
        $this->oneToOne('category', Category::CLASS, [
            'category_id' => 'id'
        ]);
        $this->oneToMany('taggings', ProductsTag::CLASS);
        $this->manyToMany('tags', Tag::CLASS, 'taggings');
        $this->oneToMany('images', Image::CLASS, [
            'id' => 'imageable_id'
        ])->where('imageable_type = ', 'product');
    }
}
