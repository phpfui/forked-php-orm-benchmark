<?php

class Tag extends Illuminate\Database\Eloquent\Model {

    protected $table = 'tags';
    protected $fillable = ['name'];
    public $timestamps = false;
}