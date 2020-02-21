<?php

/**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="imageable_type", type="string")
 * @DiscriminatorMap({"image"="Image","product"="ProductImage"})
 */
class Image extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;
    /** @Column(length=128) */
    public $path;
    /** @Column(type="integer") */
    public $imageable_id;
}