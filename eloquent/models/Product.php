<?php

class Product extends Illuminate\Database\Eloquent\Model
{

    protected $table = 'products';
    protected $fillable = ['name', 'sku', 'price'];
    public $timestamps = false;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'products_tags');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}