<?php

require_once __DIR__ . '/../AbstractTestSuite.php';

use Spiral\Database;
use Cycle\ORM;

class CycleOrmTestSuiteWithGeneratedMapper extends AbstractTestSuite
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
                        'connection' => 'sqlite:memory',
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
            'author' => [
                ORM\Schema::MAPPER      => GeneratedAuthorMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Author::class,
                ORM\Schema::DATABASE    => 'default',
                ORM\Schema::TABLE       => 'author',
                ORM\Schema::PRIMARY_KEY => 'id',
                ORM\Schema::COLUMNS     => [
                    'id'         => 'id',  // property => column
                    'first_name' => 'first_name',
                    'last_name'  => 'last_name',
                    'email'      => 'email'
                ],
                ORM\Schema::TYPECAST    => [
                    'id' => 'int',
                ],
                ORM\Schema::RELATIONS   => []
            ],
            'book'   => [
                ORM\Schema::MAPPER      => GeneratedBookMapper::class, // default POPO mapper
                ORM\Schema::ENTITY      => Book::class,
                ORM\Schema::DATABASE    => 'default',
                ORM\Schema::TABLE       => 'book',
                ORM\Schema::PRIMARY_KEY => 'id',
                ORM\Schema::COLUMNS     => [
                    'id'        => 'id',  // property => column
                    'title'     => 'title',
                    'isbn'      => 'isbn',
                    'price'     => 'price',
                    'author_id' => 'author_id',
                ],
                ORM\Schema::TYPECAST    => [
                    'id'        => 'int',
                    'author_id' => 'int',
                    'price'     => 'float',
                ],
                ORM\Schema::RELATIONS   => [
                    'author' => [
                        ORM\Relation::TYPE   => ORM\Relation::BELONGS_TO,
                        ORM\Relation::TARGET => 'author',
                        ORM\Relation::SCHEMA => [
                            ORM\Relation::CASCADE   => true,
                            ORM\Relation::NULLABLE  => true,
                            ORM\Relation::INNER_KEY => 'author_id',
                            ORM\Relation::OUTER_KEY => 'id',
                        ],
                    ]
                ]
            ]
        ]));
        $this->orm = $orm;
    }


    public function initTables()
    {
        try {
            $this->con->execute('DROP TABLE [book]');
            $this->con->execute('DROP TABLE [author]');
        } catch (\Exception $e) {
            // do nothing - the tables probably don't exist yet
        }
        $this->con->execute('CREATE TABLE [book]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[title] VARCHAR(255)  NOT NULL,
			[isbn] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[author_id] INTEGER,
			FOREIGN KEY (author_id) REFERENCES author(id)
		)');
        $this->con->execute('CREATE TABLE [author]
		(
			[id] INTEGER  NOT NULL PRIMARY KEY,
			[first_name] VARCHAR(128)  NOT NULL,
			[last_name] VARCHAR(128)  NOT NULL,
			[email] VARCHAR(128)
		)');
    }

    public function clearCache()
    {

    }

    public function beginTransaction()
    {
        $this->transaction = new ORM\Transaction($this->orm);
    }

    public function commit()
    {
        $this->transaction->run();
    }

    function runAuthorInsertion($i)
    {
        $author             = new Author();
        $author->first_name = 'John' . $i;
        $author->last_name  = 'Doe' . $i;
        $this->transaction->persist($author);

        $this->authors[] = $i + 1;
    }

    function runBookInsertion($i)
    {
        $book        = new Book;
        $book->title = 'Hello' . $i;
        $book->isbn  = '1234';
        $book->price = $i;

        $this->books[] = $i + 1;

        $author = array_rand($this->authors);
        if ($author) {
            $book->author_id = $author;
        }

        $this->transaction->persist($book);
    }

    function runPKSearch($i)
    {
        $this->orm->getRepository(Author::class)->findByPK(array_rand($this->authors));
    }

    function runHydrate($i)
    {
        $books = $this->orm->getRepository(Book::class)->select()->where('price', '>', $i)->limit(50)->fetchAll();
        foreach ($books as $book) {
        }
    }

    function runComplexQuery($i)
    {
        $this->orm->getRepository(Author::class)->select()->where('id', '>', array_rand($this->authors))
                  ->where('first_name', 'John')
                  ->where('last_name', 'Doe')
                  ->count();
    }

    function runJoinSearch($i)
    {
        $this->orm->getRepository(Book::class)->select()->where('title', 'Hello' . $i)->load('author')->fetchOne();
    }

}
