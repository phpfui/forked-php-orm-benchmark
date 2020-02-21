<?php

/** @Entity */
class Category extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;
    /** @Column(length=128) */
    public $name;
}