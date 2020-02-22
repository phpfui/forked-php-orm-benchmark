<?php

require_once __DIR__ . '/../AbstractTestSuite.php';

use Cycle\ORM;
use Spiral\Database;

class CycleOrmTestSuite extends AbstractTestSuite
{
    protected const PRODUCT_MAPPER  = ORM\Mapper\Mapper::class;
    protected const CATEGORY_MAPPER = ORM\Mapper\Mapper::class;
    protected const TAG_MAPPER      = ORM\Mapper\Mapper::class;
    protected const IMAGE_MAPPER    = ORM\Mapper\Mapper::class;

    protected $orm;

    protected $transaction;

    /** @var ORM\Select\Repository */
    protected $productRepository;

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
                    'tag'         => [
                        ORM\Schema::MAPPER      => static::TAG_MAPPER,
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
                ]
            )
        );

        $this->orm = $orm;
        $this->transaction = new ORM\Transaction($this->orm);
        $this->productRepository = $orm->getRepository('product');
    }

    public function clearCache()
    {
    }

    public function initTables()
    {
        try {
            $this->con->execute('DROP TABLE [products]');
            $this->con->execute('DROP TABLE [products_tags]');
            $this->con->execute('DROP TABLE [tags]');
            $this->con->execute('DROP TABLE [categories]');
            $this->con->execute('DROP TABLE [images]');
        } catch (\Exception $e) {
            // do nothing - the tables probably don't exist yet
        }
        $this->con->execute(
            'CREATE TABLE [products]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[name] VARCHAR(255)  NOT NULL,
			[sku] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[category_id] INTEGER,
			FOREIGN KEY (category_id) REFERENCES categories(id)
		)'
        );
        $this->con->execute(
            'CREATE TABLE [categories]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[name] VARCHAR(128)  NOT NULL
		)'
        );
        $this->con->execute(
            'CREATE TABLE [images]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[imageable_id] INTEGER,
			[imageable_type] VARCHAR(128),
			[path] VARCHAR(128)  NOT NULL
		)'
        );
        $this->con->execute(
            'CREATE TABLE [tags]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[name] VARCHAR(128)  NOT NULL
		)'
        );
        $this->con->execute(
            'CREATE TABLE [products_tags]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[product_id] INTEGER,
			[tag_id] INTEGER,
			[position] INTEGER
		)'
        );
    }

    public function beginTransaction()
    {
    }

    public function commit()
    {
        $this->transaction->run();
    }

    function insert($i)
    {
        $product = new Product(
            [
                'name'  => 'Product #' . $i,
                'sku'   => 'SKU #' . $i,
                'price' => sqrt(1000 + $i * 100)
            ]
        );
        $product->category = new Category(
            [
                'name' => 'Category #c' . $i
            ]
        );
        $product->images = new \Doctrine\Common\Collections\ArrayCollection(
            [
                new Image(
                    [
                        'path' => 'image_' . $i . '.jpg'
                    ]
                )
            ]
        );

        $product->tags = new \Doctrine\Common\Collections\ArrayCollection(
            [
                new Tag(['name' => 'Tag #t1_' . $i]),
                new Tag(['name' => 'Tag #t2_' . $i])
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

    public function test_insert()
    {
        $product = $this->insert(0);

        $product = $this->productRepository->findByPK($product->id);

        $this->assertNotNull($product, 'Product not found');
        $this->assertNotNull($product->category_id, 'Category was not associated with the product');
        $this->assertNotNull($product->images[0]->path, 'Image not present');
        $this->assertNotNull($product->tags[0]->name, 'Tag not present');
    }

    function prepare_update()
    {
        $this->product = $this->productRepository->findByPK(1);
    }

    function update($i)
    {
        $this->product->name = 'New product name ' . $i;
        $this->product->category->name = 'New category name ' . $i;
        $this->product->images[0]->path = 'new_path_' . $i . '.jpg';
        $this->product->tags[0]->name = 'New tag name ' . $i;

        $this->transaction->persist($this->product);
        $this->transaction->run();
    }

    function test_update()
    {
        $this->product->name = 'New product name';
        $this->product->category->name = 'New category name';
        $this->product->images[0]->path = 'new_path.jpg';
        $this->product->tags[0]->name = 'New tag name';

        $this->transaction->persist($this->product);
        $this->transaction->run();

        $product = $this->productRepository->findByPK(1);

        $this->assertEquals('New product name', $product->name);
        $this->assertEquals('New category name', $product->category->name);
        $this->assertEquals('new_path.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name', $product->tags[0]->name);
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }

    function find($i)
    {
        $product = $this->productRepository->findByPK(1);
    }

    function test_find()
    {
        $product = $this->productRepository->findByPK(1);
        $this->assertEquals('New product name ' . (self::NB_TEST - 1), $product->name); // changed by "update"
    }

    function complexQuery($i)
    {
        $this->productRepository
            ->select()
            ->with('category')
            ->where('product.id', '>', 50)
            ->where('category.id', '<', 300)
            ->count('*');
    }

    function test_complexQuery()
    {
        $count = $this->productRepository
            ->select()
            ->where('product.id', '>', 50)
            ->where('category.id', '<', 300) // with can be ommited, orm will join automatically
            ->count('*');

        $this->assertEquals(249, $count);
    }

    function relations($i)
    {
        $products = $this->productRepository
            ->select()
            ->load(['category', 'tags', 'images'])
            ->where('price', '>', 50)
            ->limit(10)
            ->fetchAll();

        foreach ($products as $product) {
        }
    }

    function test_relations()
    {
        $product = $this->productRepository->findByPK(1);

        $lastRun = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->name);
        $this->assertEquals('New category name ' . $lastRun, $product->category->name);
        $this->assertEquals('new_path_' . $lastRun . '.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name ' . $lastRun, $product->tags[0]->name);
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }
}
