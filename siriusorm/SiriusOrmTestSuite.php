<?php


use Sirius\Orm\Connection;
use Sirius\Orm\ConnectionLocator;
use Sirius\Orm\Orm;

require_once __DIR__ . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class SiriusOrmTestSuite extends AbstractTestSuite
{

    /**
     * @var Orm
     */
    private $orm;

    /**
     * @var \app\Entity\Product
     */
    private $product;

    function initialize()
    {
        $loader = require_once __DIR__ . "/vendor/autoload.php";

        $this->con = Connection::new('sqlite::memory:');
        $this->orm = new Orm(ConnectionLocator::new($this->con));

        $this->initTables();

        require_once __DIR__ . '/definitions.php';

        $orm = $this->orm;
        $this->orm->register('products', function ($orm) {
            return new app\Mapper\ProductMapper($orm);
        });
        $this->orm->register('categories', function ($orm) {
            return new app\Mapper\CategoryMapper($orm);
        });
        $this->orm->register('tags', function ($orm) {
            return new app\Mapper\TagMapper($orm);
        });
        $this->orm->register('images', function ($orm) {
            return new app\Mapper\ImageMapper($orm);
        });
    }

    function clearCache()
    {
    }

    function beginTransaction()
    {
        $this->transaction = $this->con->beginTransaction();
    }

    function commit()
    {
        $this->con->commit();
    }


    function insert($i)
    {
        $mapper  = $this->orm->get('products');
        $product = $mapper->newEntity([
            'name'     => 'Product #' . $i,
            'sku'      => 'SKU #' . $i,
            'price'    => sqrt(1000 + $i * 100),
            'category' => [
                'name' => 'Category #c' . $i
            ],
            'images'   => [
                ['path' => 'image_' . $i . '.jpg']
            ],
            'tags'     => [
                ['name' => 'Tag #t1_' . $i],
                ['name' => 'Tag #t2_' . $i]
            ]
        ]);

        $mapper->save($product, ['category', 'images', 'tags']);

        $this->products[] = $product->getId();

        return $product;
    }

    public function test_insert()
    {
        $mapper  = $this->orm->get('products');
        $product = $this->insert(0);
        /** @var \app\Entity\Product $product */
        $product = $mapper->find($product->getId());
        $this->assertNotNull($product, 'Product not found');
        $this->assertNotNull($product->getCategoryId(), 'Category was not associated with the product');
        $this->assertNotNull($product->getImages()->get(0)->getPath(), 'Image not present');
        $this->assertNotNull($product->getTags()->get(0)->getName(), 'Tag not present');
    }

    function prepare_update()
    {
        $mapper        = $this->orm->get('products');
        $this->product = $this->insert(0);
        $this->product = $mapper->find(1, ['category', 'images', 'tags']);
    }

    function update($i)
    {
        $mapper = $this->orm->get('products');
        $this->product->setName('New product name ' . $i);
        $this->product->getCategory()->setName('New category name ' . $i);
        $this->product->getImages()->get(0)->setPath('new_path_' . $i . '.jpg');
        $this->product->getTags()->get(0)->setName('New tag name ' . $i);
        $mapper->save($this->product, ['category', 'images', 'tags']);
    }

    function test_update()
    {
        $mapper                         = $this->orm->get('products');
        $this->product->setName('New product name');
        $this->product->getCategory()->setName('New category name');
        $this->product->getImages()->get(0)->setPath('new_path.jpg');
        $this->product->getTags()->get(0)->setName('New tag name');
        $mapper->save($this->product, ['category', 'images', 'tags']);
        $product = $mapper->find(1, ['category', 'tags', 'images']);

        $this->assertEquals('New product name', $product->getName());
        $this->assertEquals('New category name', $product->getCategory()->getName());
        $this->assertEquals('new_path.jpg', $product->getImages()->get(0)->getPath());

        // order not preserved for some reason
        $this->assertEquals('New tag name', $product->getTags()->get(1)->getName());
        $this->assertEquals('Tag #t2_0', $product->getTags()->get(0)->getName());
    }

    function find($i)
    {
        $mapper = $this->orm->get('products');
        $mapper->find(1);
    }

    function test_find()
    {
        $mapper  = $this->orm->get('products');
        $product = $mapper->find(1);
        $lastRun = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->getName()); // changed by "update"
    }

    function complexQuery($i)
    {
        $this->orm->get('products')
                  ->newQuery()
                  ->join('INNER', 'categories', 'categories.id = products.category_id')
                  ->where('products.id', 50, '>')
                  ->where('categories.id', 300, '<')
                  ->count();
    }

    function test_complexQuery()
    {
        $this->assertEquals(249, $this->orm->get('products')
                                           ->newQuery()
                                           ->join('INNER', 'categories', 'categories.id = products.category_id')
                                           ->where('products.id', 50, '>')
                                           ->where('categories.id', 300, '<')
                                           ->count());
    }

    function relations($i)
    {
        $products = $this->orm->get('products')
                              ->newQuery()
                              ->load('category', 'tags', 'images')
                              ->where('price', 50, '>')
                              ->limit(10)
                              ->get();
        foreach ($products as $product) {

        }
    }

    function test_relations()
    {
        $product = $this->orm->get('products')->find(1);
        $lastRun = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->getName());
        $this->assertEquals('New category name ' . $lastRun, $product->getCategory()->getName());
        $this->assertEquals('new_path_' . $lastRun . '.jpg', $product->getImages()->get(0)->getPath());
        $this->assertEquals('New tag name ' . $lastRun, $product->getTags()->get(1)->getName());
        $this->assertEquals('Tag #t2_0', $product->getTags()->get(0)->getName());
    }
}
