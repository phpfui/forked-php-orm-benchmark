<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

class EloquentTestSuite extends AbstractTestSuite
{
    /*
     * @var $capsule Illuminate\Database\Capsule\Manager
     */
    protected $capsule = null;

	function initialize()
	{
        $loader = require_once "vendor/autoload.php";

        $this->capsule = new Illuminate\Database\Capsule\Manager ;

        $this->capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  =>  ':memory:',
        ]);

        $this->con = $this->capsule->getConnection()->getPdo();

        // Set the event dispatcher used by Eloquent models... (optional)
        $this->capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container()));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();

        $loader->add('', __DIR__ . '/models');
		$this->initTables();
	}
	
	function clearCache()
	{

	}
	
	function beginTransaction()
	{
        $this->capsule->getConnection()->beginTransaction();
	}
	
	function commit()
	{
        $this->capsule->getConnection()->commit();
	}
	
	function runAuthorInsertion($i)
	{
		$author = new Author();
		$author->first_name = 'John' . $i;
		$author->last_name = 'Doe' . $i;
		$author->save();
		$this->authors[]= $author;
	}

	function runBookInsertion($i)
	{
		$book = new Book();
		$book->title = 'Hello' . $i;
		$book->author()->associate($this->authors[array_rand($this->authors)]);
		$book->isbn = '1234';
		$book->price = $i;
		$book->save();
		$this->books[]= $book;
	}
	
	function runPKSearch($i)
	{
        $author = Author::find($this->authors[array_rand($this->authors)]->id);
	}
	
	function runComplexQuery($i)
	{
		$authors = Author::where('id', '>', $this->authors[array_rand($this->authors)]->id)
            ->orWhere($this->capsule->getConnection()->raw('(first_name || last_name)'), '=', 'John Doe')
            ->count();
	}

	function runHydrate($i)
	{
		$books = Book::where('price', '>', $i)->limit(50)->get();
	}
	
	function runJoinSearch($i)
	{
        $books = Book::where('title', 'Hello' . $i)->with('author')->first();
	}
	
}