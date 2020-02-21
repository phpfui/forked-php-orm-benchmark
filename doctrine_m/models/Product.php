<?php

/** @Entity */
class Product extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue */
    public $id;
    /** @Column */
    public $name;
    /** @Column(length=24) */
    public $sku;
    /** @Column(type="decimal") */
    public $price;
    /** @Column(type="integer") */
    public $category_id;
    /** @ManyToOne(targetEntity="Category",cascade={"persist"},fetch="EAGER") */
    public $category;
    /**
     * @ManyToMany(targetEntity="Tag",cascade={"persist"},fetch="EAGER")
     * @JoinTable(name="products_tags")
     */
    public $tags;
    /** ONE-TO-MANY BIDIRECTIONAL, INVERSE SIDE
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product",cascade={"persist"},fetch="EAGER")
     * @ORM\JoinColumn(name="id", referencedColumnName="imageable_id", nullable=true)
     */
    public $images;

}