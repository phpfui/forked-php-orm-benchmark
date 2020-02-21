<?php

require_once __DIR__ . '/../AbstractTestSuite.php';
require_once __DIR__ . '/CycleOrmTestSuiteWithGeneratedMapper.php';

use Spiral\Database;
use Cycle\ORM;

class CycleOrmTestSuite extends CycleOrmTestSuiteWithGeneratedMapper
{
    protected $orm;

    public function initialize()
    {
        $loader = require_once "vendor/autoload.php";
        $loader->add('', __DIR__ . '/src');

        $database  = new Database\DatabaseManager(
            new Database\Config\DatabaseConfig([
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
            ])
        );
        $this->con = $database->database()->getDriver();
        $this->initTables();

        $orm       = new ORM\ORM(new ORM\Factory($database));
        $orm       = $orm->withSchema(new ORM\Schema([
            'product'  => [
                ORM\Schema::MAPPER      => ProductMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Product::class,
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
                            ORM\Relation::CASCADE   => true,
                            ORM\Relation::NULLABLE  => true,
                            ORM\Relation::INNER_KEY => 'id',
                            ORM\Relation::OUTER_KEY => 'id',
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
            'category' => [
                ORM\Schema::MAPPER      => CategoryMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Category::class,
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
            'tag'      => [
                ORM\Schema::MAPPER      => TagMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Tag::class,
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
            'image'    => [
                ORM\Schema::MAPPER      => ImageMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Image::class,
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
        ]));
        $this->orm = $orm;
    }

}
