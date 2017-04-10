<?php

require_once dirname(__FILE__) . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class FuelTestSuite extends AbstractTestSuite
{
	function initialize()
	{
		define('DOCROOT', realpath(__DIR__.'/public/').DIRECTORY_SEPARATOR);
		define('APPPATH', realpath(__DIR__.'/fuel/app/').DIRECTORY_SEPARATOR);
		define('PKGPATH', realpath(__DIR__.'/fuel/packages/').DIRECTORY_SEPARATOR);
		define('COREPATH', realpath(__DIR__.'/fuel/core/').DIRECTORY_SEPARATOR);
		defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
		defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

		if ( ! file_exists(COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php'))
		{
			die('No composer autoloader found. Please run composer to install the FuelPHP framework dependencies first!');
		}

		require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
		class_alias('Fuel\\Core\\Autoloader', 'Autoloader');
		require APPPATH.'bootstrap.php';

		require_once APPPATH.'classes/model/Model_Author.php';
		require_once APPPATH.'classes/model/Model_Book.php';

		$this->con = \Database_Connection::instance()->connection();
		$this->initTables();
	}

	function clearCache()
	{
	}

	function beginTransaction()
	{
		$this->con->beginTransaction();
	}

	function commit()
	{
		$this->con->commit();
	}

	function runAuthorInsertion($i)
	{

		$author = new \Model_Author();
		$author->first_name = 'John' . $i;
		$author->last_name = 'Doe' . $i;
		$author->save();

		$this->authors[]= $author->id;
		Cache::delete_all();
	}

	function runBookInsertion($i)
	{
		$book = new \Model_Book();
		$book->title = 'Hello' . $i;
		$book->isbn = '1234' . $i;
		$book->price = $i;
		$book->author_id = $this->authors[array_rand($this->authors)];
		$book->save();

		$this->books[]= $book->id;
		Cache::delete_all();
	}

	function runPKSearch($i)
	{
		$author = new \Model_Author();
		$author->find($this->authors[array_rand($this->authors)]);
		Cache::delete_all();
	}

	function runHydrate($i)
	{

		$books = \Model_Book::find('all', array(
			'limit' => 5,
		    'where' => array(
		        array('price', '>', $i),
		    ),
		));

		foreach($books as $book) {}
		Cache::delete_all();
	}

	function runComplexQuery($i)
	{

		$count = DB::select(DB::expr('COUNT(*) as count'))
			->from('author')
        	->where('id', '>', $this->authors[array_rand($this->authors)])
        	->or_where(DB::expr('first_name || last_name'), 'John Doe')
			->limit(5)
			->execute();
		Cache::delete_all();
	}

	function runJoinSearch($i)
	{

		$book = DB::select()->from('book')
			->join('author', 'left')
			->on('book.author_id', '=', 'author.id')
			->where('book.title', 'Hello' . $i)
			->limit(1)->as_object();
		Cache::delete_all();
	}
}