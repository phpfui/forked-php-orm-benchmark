<?php

class BaseEntity
{
    public function __construct($array)
    {
        foreach ($array as $k => $v) {
            $this->$k = $v;
        }
    }
}