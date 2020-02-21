<?php

class Image extends Illuminate\Database\Eloquent\Model {

    protected $table = 'images';
    protected $fillable = ['path'];
    public $timestamps = false;
}