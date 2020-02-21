<?php

class Category extends Illuminate\Database\Eloquent\Model {

    protected $table = 'categories';
    protected $fillable = ['name'];
    public $timestamps = false;
}