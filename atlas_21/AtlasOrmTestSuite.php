<?php

use Atlas\Orm\Atlas;
use Atlas\Pdo\Connection;

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class AtlasOrmTestSuite extends AbstractTestSuite
{

    /**
     * @var \Atlas\Orm\Atlas
     */
    private $atlas;

    function initialize()
    {
        $loader = require_once "vendor/autoload.php";
        $loader->add('', __DIR__ . '/src');

        $this->con = Connection::new('sqlite:memory');

        $this->atlas = Atlas::new(
            $this->con
        );

        $this->initTables();
    }

    function clearCache()
    {
    }

    function beginTransaction()
    {
        $this->transaction = $this->atlas->beginTransaction();
    }

    function commit()
    {
        $this->atlas->commit();
    }

    function runAuthorInsertion($i)
    {
        $author = $this->atlas->newRecord(\Author\Author::class, [
            'first_name' => 'John' . $i,
            'last_name'  => 'Doe' . $i,
        ]);
        $this->atlas->insert($author);
        $this->authors[] = $this->con->lastInsertId();
    }

    function runBookInsertion($i)
    {
        $book = $this->atlas->newRecord(\Book\Book::class, [
            'title'     => 'Hello' . $i,
            'isbn'      => '1234' . $i,
            'price'     => $i,
            'author_id' => $this->authors[array_rand($this->authors)],
        ]);
        $this->atlas->insert($book);
        $this->books[] = $this->con->lastInsertId();

    }

    function runPKSearch($i)
    {
        $author = $this->atlas->fetchRecord(\Author\Author::class, $i);
    }

    function runHydrate($i)
    {
        $stmt = $this->atlas
            ->select(\Book\Book::class)
            ->where('price > ', $i)
            ->limit(50);

        foreach ($stmt->fetchRecordSet() as $book) {
        }
    }

    function runComplexQuery($i)
    {
        $stmt = $this->atlas
            ->select(\Author\Author::class)
            ->whereSprintf('id > %s OR (first_name || last_name) = %s ', (int)$this->authors[array_rand($this->authors)], 'John Doe')
            ->fetchCount();

    }

    function runJoinSearch($i)
    {
        $book = $this->atlas
            ->select(\Book\Book::class)
            ->where('title=', 'Hello' . $i)
            ->with(['author'])
            ->fetchRecord();

        return $book;
        //$author = $book->author()->select('id', 'first_name', 'last_name', 'email')->fetch();
    }

}