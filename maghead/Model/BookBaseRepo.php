<?php
namespace AuthorBooks\Model;
require_once __DIR__ . '/BookSchemaProxy.php';
use Maghead\Schema\SchemaLoader;
use Maghead\Result;
use Maghead\BaseModel;
use Maghead\Inflator;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use Maghead\BaseRepo;
class BookBaseRepo
    extends BaseRepo
{
    const SCHEMA_CLASS = 'AuthorBooks\\Model\\BookSchema';
    const SCHEMA_PROXY_CLASS = 'AuthorBooks\\Model\\BookSchemaProxy';
    const COLLECTION_CLASS = 'AuthorBooks\\Model\\BookCollection';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Book';
    const TABLE = 'book';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    const TABLE_ALIAS = 'm';
    const FIND_BY_PRIMARY_KEY_SQL = 'SELECT * FROM book WHERE id = ? LIMIT 1';
    const LOAD_BY_ISBN_SQL = 'SELECT * FROM book WHERE isbn = :isbn LIMIT 1';
    const DELETE_BY_PRIMARY_KEY_SQL = 'DELETE FROM book WHERE id = ?';
    const FETCH_AUTHOR_SQL = 'SELECT * FROM author WHERE id = ? LIMIT 1';
    public static $columnNames = array (
      0 => 'id',
      1 => 'title',
      2 => 'isbn',
      3 => 'price',
      4 => 'author_id',
    );
    public static $columnHash = array (
      'id' => 1,
      'title' => 1,
      'isbn' => 1,
      'price' => 1,
      'author_id' => 1,
    );
    public static $mixinClasses = array (
    );
    protected $table = 'book';
    protected $loadStm;
    protected $deleteStm;
    protected $loadByIsbnStm;
    protected $fetchAuthorStm;
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\BookSchemaProxy;
    }
    public function loadByPrimaryKey($pkId)
    {
        if (!$this->loadStm) {
           $this->loadStm = $this->read->prepare(self::FIND_BY_PRIMARY_KEY_SQL);
           $this->loadStm->setFetchMode(PDO::FETCH_CLASS, 'AuthorBooks\Model\Book');
        }
        return static::_stmFetchOne($this->loadStm, [$pkId]);
    }
    public function loadByIsbn($value)
    {
        if (!$this->loadByIsbnStm) {
            $this->loadByIsbnStm = $this->read->prepare(self::LOAD_BY_ISBN_SQL);
            $this->loadByIsbnStm->setFetchMode(PDO::FETCH_CLASS, '\AuthorBooks\Model\Book');
        }
        return static::_stmFetchOne($this->loadByIsbnStm, [':isbn' => $value ]);
    }
    public function deleteByPrimaryKey($pkId)
    {
        if (!$this->deleteStm) {
           $this->deleteStm = $this->write->prepare(self::DELETE_BY_PRIMARY_KEY_SQL);
        }
        return $this->deleteStm->execute([$pkId]);
    }
    public function fetchAuthorOf(BaseModel $record)
    {
        if (!$this->fetchAuthorStm) {
            $this->fetchAuthorStm = $this->read->prepare(self::FETCH_AUTHOR_SQL);
            $this->fetchAuthorStm->setFetchMode(PDO::FETCH_CLASS, '\AuthorBooks\Model\Author');
        }
        return static::_stmFetchOne($this->fetchAuthorStm, [$record->author_id]);
    }
}
