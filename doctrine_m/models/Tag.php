<?php

/** @Entity */
class Tag extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;
    /** @Column(length=128) */
    public $name;
}