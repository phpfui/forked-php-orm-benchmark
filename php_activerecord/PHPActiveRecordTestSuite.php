<?php

require_once dirname(__FILE__).'/../AbstractTestSuite.php';

class PHPActiveRecordTestSuite extends AbstractTestSuite
{
  
    protected $cfg;

    public function initialize()
    {
        require_once 'vendor/autoload.php';

        ActiveRecord\Config::initialize(function ($cfg) {
            $cfg->set_model_directory(__DIR__.'/models');
            $cfg->set_connections(array(
                'development' => 'sqlite://:memory:', ));
        });

        $this->con = ActiveRecord\ConnectionManager::get_connection()->connection;
        $this->initTables();
    }

    public function clearCache()
    {
    }

    public function beginTransaction()
    {
        //$this->con->beginTransaction();
    }

    public function commit()
    {
        //$this->con->commit();
    }

    public function runAuthorInsertion($i)
    {
        $author = new Author();
        $author->first_name = 'John'.$i;
        $author->last_name = 'Doe'.$i;
        $author->save();
        $this->authors[] = $author;
    }

    public function runBookInsertion($i)
    {
        $book = new Book();
        $book->title = 'Hello'.$i;
        $book->author_id = $this->authors[array_rand($this->authors)]->id;
        $book->isbn = '1234';
        $book->price = $i;
        $book->save();
        $this->books[] = $book;
    }

    public function runPKSearch($i)
    {
        $author = Author::find($this->authors[array_rand($this->authors)]->id);
    }

    public function runComplexQuery($i)
    {
        $random_author_id = $this->authors[array_rand($this->authors)]->id;

        $authors = Author::count(
            ['conditions' => [
                '? > id OR (first_name || last_name) LIKE ?',
                $random_author_id,
                'John Doe',
            ]]
         );
    }

    public function runHydrate($i)
    {
        $books = Book::find('all', ['conditions' => ['price > ?', $i], 'limit' => 5]);

        foreach ($books as $book) {
        }
    }

    public function runJoinSearch($i)
    {
        Book::first([
            'conditions' => ['title LIKE ?', 'Hello'.$i],
            'joins' => ['author'],
        ]);
    }
}
