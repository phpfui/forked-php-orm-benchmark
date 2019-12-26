<?php

require_once __DIR__ . '/../AbstractTestSuite.php';
require_once __DIR__ . '/vendor/autoload.php';

class PHPixieTestSuite extends AbstractTestSuite
{
    protected $orm;

    public function initialize()
    {
        $slice = new \PHPixie\Slice();

        $database  = new \PHPixie\Database($slice->arrayData(array(
            'default' => array(
                'driver'     => 'pdo',
                'connection' => 'sqlite::memory:'
            )
        )));
        $this->con = $database->get()->pdo();
        $this->initTables();

        $this->orm = new \PHPixie\ORM($database, $slice->arrayData(array(
            'models'        => array(
                'author' => array(
                    'table'      => 'author',
                    'type'       => 'database',
                    'connection' => 'default',
                    'id'         => 'id'
                ),
                'book'   => array(
                    'table'      => 'book',
                    'type'       => 'database',
                    'connection' => 'default',
                    'id'         => 'id'
                )
            ),
            'relationships' => array(
                array(
                    'type'         => 'oneToMany',
                    'owner'        => 'author',
                    'items'        => 'book',
                    'itemsOptions' => array(
                        'ownerKey' => 'author_id',
                    )
                )
            )
        )));
    }

    public function clearCache()
    {

    }

    public function beginTransaction()
    {

    }

    public function commit()
    {

    }

    function runAuthorInsertion($i)
    {
        $author             = $this->orm->createEntity('author');
        $author->first_name = 'John' . $i;
        $author->last_name  = 'Doe' . $i;
        $author->save();
        $this->authors[] = $author->id();
    }

    function runBookInsertion($i)
    {
        $book        = $this->orm->createEntity('book');
        $book->title = 'Hello' . $i;
        $book->isbn  = '1234';
        $book->price = $i;
        $book->save();
        $this->books[] = $book->id();

        $author = array_rand($this->authors);
        if ($author) {
            $book->author->set($author);
        } else {
        }
    }

    function runPKSearch($i)
    {
        $this->orm->query('author')->in(array_rand($this->authors))->findOne();
    }

    function runHydrate($i)
    {
        $books = $this->orm->query('book')->where('price', '>', $i)->limit(5)->find();
        foreach ($books as $book) {
        }
    }

    function runComplexQuery($i)
    {
        $this->orm->query('author')->where('id', '>', array_rand($this->authors))
                  ->startOrGroup()
                  ->where('first_name', 'John')
                  ->where('last_name', 'Doe')
                  ->endGroup()
                  ->count();
    }

    function runJoinSearch($i)
    {
        $this->orm->query('book')->where('title', 'Hello' . $i)->findOne(array('author'));
    }
}
