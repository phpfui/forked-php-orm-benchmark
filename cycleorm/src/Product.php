<?php

class Product extends BaseEntity
{
    public $id;
    public $name;
    public $sku;
    public $price;
    public $category_id;
    public $category;
    public $images;
    public $tags;
}