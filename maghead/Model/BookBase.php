<?php
namespace AuthorBooks\Model;
require_once __DIR__ . '/BookSchemaProxy.php';
use Maghead\Schema\SchemaLoader;
use Maghead\Result;
use Maghead\Inflator;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use Maghead\BaseModel;
class BookBase
    extends BaseModel
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
    public static $column_names = array (
      0 => 'id',
      1 => 'title',
      2 => 'isbn',
      3 => 'price',
      4 => 'author_id',
    );
    public static $mixin_classes = array (
    );
    protected $table = 'book';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public $id;
    public $title;
    public $isbn;
    public $price;
    public $author_id;
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\BookSchemaProxy;
    }
    public static function createRepo($write, $read)
    {
        return new \AuthorBooks\Model\BookBaseRepo($write, $read);
    }
    public function getId()
    {
        return intval($this->id);
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getIsbn()
    {
        return $this->isbn;
    }
    public function getPrice()
    {
        return floatval($this->price);
    }
    public function getAuthorId()
    {
        return intval($this->author_id);
    }
    public function getKeyName()
    {
        return 'id';
    }
    public function getKey()
    {
        return $this->id;
    }
    public function hasKey()
    {
        return isset($this->id);
    }
    public function setKey($key)
    {
        return $this->id = $key;
    }
    public function getData()
    {
        return ["id" => $this->id, "title" => $this->title, "isbn" => $this->isbn, "price" => $this->price, "author_id" => $this->author_id];
    }
    public function setData(array $data)
    {
        if (array_key_exists("id", $data)) { $this->id = $data["id"]; }
        if (array_key_exists("title", $data)) { $this->title = $data["title"]; }
        if (array_key_exists("isbn", $data)) { $this->isbn = $data["isbn"]; }
        if (array_key_exists("price", $data)) { $this->price = $data["price"]; }
        if (array_key_exists("author_id", $data)) { $this->author_id = $data["author_id"]; }
    }
    public function clear()
    {
        $this->id = NULL;
        $this->title = NULL;
        $this->isbn = NULL;
        $this->price = NULL;
        $this->author_id = NULL;
    }
    public function fetchAuthor()
    {
        return static::defaultRepo()->fetchAuthorOf($this);
    }
}
