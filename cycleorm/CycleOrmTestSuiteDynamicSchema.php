<?php

require_once __DIR__ . '/../AbstractTestSuite.php';
require_once __DIR__ . '/CycleOrmTestSuite.php';

use Cycle\ORM;
use Spiral\Database;

class CycleOrmTestSuiteDynamicSchema extends CycleOrmTestSuite
{
    protected const PRODUCT_MAPPER  = \Cycle\ORM\Mapper\StdMapper::class;
    protected const CATEGORY_MAPPER = \Cycle\ORM\Mapper\StdMapper::class;
    protected const TAG_MAPPER      = \Cycle\ORM\Mapper\StdMapper::class;
    protected const IMAGE_MAPPER    = \Cycle\ORM\Mapper\StdMapper::class;

    public function initialize()
    {
        $loader = require_once "vendor/autoload.php";
        $loader->add('', __DIR__ . '/src');

        $database = new Database\DatabaseManager(
            new Database\Config\DatabaseConfig(
                [
                    'default'     => 'default',
                    'databases'   => [
                        'default' => ['connection' => 'memory']
                    ],
                    'connections' => [
                        'memory' => [
                            'driver'     => Database\Driver\SQLite\SQLiteDriver::class,
                            'connection' => 'sqlite::memory:',
                            'username'   => '',
                            'password'   => '',
                        ]
                    ]
                ]
            )
        );
        $this->con = $database->database()->getDriver();
        $this->initTables();

        $orm = new ORM\ORM(new ORM\Factory($database));
        $orm = $orm->withSchema(
            new ORM\Schema(
                [
                    'product'     => [
                        ORM\Schema::MAPPER      => static::PRODUCT_MAPPER,
                        ORM\Schema::DATABASE    => 'default',
                        ORM\Schema::TABLE       => 'products',
                        ORM\Schema::PRIMARY_KEY => 'id',
                        ORM\Schema::COLUMNS     => [
                            'id'          => 'id',  // property => column
                            'name'        => 'name',
                            'sku'         => 'sku',
                            'price'       => 'price',
                            'category_id' => 'category_id'
                        ],
                        ORM\Schema::TYPECAST    => [
                            'id' => 'int',
                        ],
                        ORM\Schema::RELATIONS   => [
                            'category' => [
                                ORM\Relation::TYPE   => ORM\Relation::BELONGS_TO,
                                ORM\Relation::TARGET => 'category',
                                ORM\Relation::SCHEMA => [
                                    ORM\Relation::CASCADE   => true,
                                    ORM\Relation::NULLABLE  => true,
                                    ORM\Relation::INNER_KEY => 'category_id',
                                    ORM\Relation::OUTER_KEY => 'id',
                                ],
                            ],
                            'tags'     => [
                                ORM\Relation::TYPE   => ORM\Relation::MANY_TO_MANY,
                                ORM\Relation::TARGET => 'tag',
                                ORM\Relation::SCHEMA => [
                                    ORM\Relation::CASCADE           => true,
                                    ORM\Relation::NULLABLE          => true,
                                    ORM\Relation::INNER_KEY         => 'id',
                                    ORM\Relation::OUTER_KEY         => 'id',
                                    ORM\Relation::THROUGH_ENTITY    => 'product_tag',
                                    ORM\Relation::THROUGH_INNER_KEY => 'product_id',
                                    ORM\Relation::THROUGH_OUTER_KEY => 'tag_id',
                                ],
                            ],
                            'images'   => [
                                ORM\Relation::TYPE   => ORM\Relation::MORPHED_HAS_MANY,
                                ORM\Relation::TARGET => 'image',
                                ORM\Relation::SCHEMA => [
                                    ORM\Relation::CASCADE   => true,
                                    ORM\Relation::NULLABLE  => true,
                                    ORM\Relation::INNER_KEY => 'id',
                                    ORM\Relation::OUTER_KEY => 'imageable_id',
                                    ORM\Relation::MORPH_KEY => 'imageable_type',
                                ],
                            ],
                        ]
                    ],
                    'category'    => [
                        ORM\Schema::MAPPER      => static::CATEGORY_MAPPER,
                        ORM\Schema::DATABASE    => 'default',
                        ORM\Schema::TABLE       => 'categories',
                        ORM\Schema::PRIMARY_KEY => 'id',
                        ORM\Schema::COLUMNS     => [
                            'id'   => 'id',  // property => column
                            'name' => 'name'
                        ],
                        ORM\Schema::TYPECAST    => [
                            'id' => 'int'
                        ],
                        ORM\Schema::RELATIONS   => [

                        ]
                    ],
                    'tag'         => [
                        ORM\Schema::MAPPER      => static::TAG_MAPPER,
                        ORM\Schema::DATABASE    => 'default',
                        ORM\Schema::TABLE       => 'tags',
                        ORM\Schema::PRIMARY_KEY => 'id',
                        ORM\Schema::COLUMNS     => [
                            'id'   => 'id',  // property => column
                            'name' => 'name'
                        ],
                        ORM\Schema::TYPECAST    => [
                            'id' => 'int'
                        ],
                        ORM\Schema::RELATIONS   => [

                        ]
                    ],
                    'product_tag' => [
                        ORM\Schema::MAPPER      => ORM\Mapper\StdMapper::class, // we can emulate the entity
                        ORM\Schema::DATABASE    => 'default',
                        ORM\Schema::TABLE       => 'products_tags',
                        ORM\Schema::PRIMARY_KEY => 'id',
                        ORM\Schema::COLUMNS     => [
                            'id'         => 'id',  // property => column
                            'product_id' => 'product_id',
                            'tag_id'     => 'tag_id',
                            'position'   => 'position',
                        ],
                        ORM\Schema::TYPECAST    => [
                            'id' => 'int'
                        ],
                        ORM\Schema::RELATIONS   => [

                        ]
                    ],
                    'image'       => [
                        ORM\Schema::MAPPER      => static::IMAGE_MAPPER,
                        ORM\Schema::DATABASE    => 'default',
                        ORM\Schema::TABLE       => 'images',
                        ORM\Schema::PRIMARY_KEY => 'id',
                        ORM\Schema::COLUMNS     => [
                            'id'             => 'id',  // property => column
                            'path'           => 'path',
                            'imageable_id'   => 'imageable_id',
                            'imageable_type' => 'imageable_type',
                        ],
                        ORM\Schema::TYPECAST    => [
                            'id' => 'int'
                        ],
                        ORM\Schema::RELATIONS   => [

                        ]
                    ]
                ]
            )
        );

        $this->orm = $orm;
        $this->transaction = new ORM\Transaction($this->orm);
        $this->productRepository = $orm->getRepository('product');
    }

    function insert($i)
    {
        $product = $this->orm->make(
            'product',
            [
                'name'  => 'Product #' . $i,
                'sku'   => 'SKU #' . $i,
                'price' => sqrt(1000 + $i * 100)
            ]
        );

        $product->category = $this->orm->make('category', ['name' => 'Category #c' . $i]);

        $product->images = new \Doctrine\Common\Collections\ArrayCollection(
            [
                $this->orm->make('image', ['path' => 'image_' . $i . '.jpg'])
            ]
        );

        $product->images->add($this->orm->make('image', ['path' => 'image_' . $i . '.jpg']));

        $product->tags = new \Doctrine\Common\Collections\ArrayCollection(
            [
                $this->orm->make('tag', ['name' => 'Tag #t1_' . $i]),
                $this->orm->make('tag', ['name' => 'Tag #t2_' . $i])
            ]
        );

        $this->transaction->persist($product);
        $this->transaction->run();

        // make sure to properly close the heap while working with batch iterations to free up some memory
        // if this method not used the test_insert will use the same entity (literally) due
        // to the presence of EntityManager
        $this->orm->getHeap()->clean();

        return $product;
    }
}
