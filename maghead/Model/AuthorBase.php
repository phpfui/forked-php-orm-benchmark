<?php
namespace AuthorBooks\Model;
require_once __DIR__ . '/AuthorSchemaProxy.php';
use Maghead\Schema\SchemaLoader;
use Maghead\Result;
use Maghead\Inflator;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use Maghead\BaseModel;
class AuthorBase
    extends BaseModel
{
    const SCHEMA_CLASS = 'AuthorBooks\\Model\\AuthorSchema';
    const SCHEMA_PROXY_CLASS = 'AuthorBooks\\Model\\AuthorSchemaProxy';
    const COLLECTION_CLASS = 'AuthorBooks\\Model\\AuthorCollection';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Author';
    const TABLE = 'author';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    const TABLE_ALIAS = 'm';
    public static $column_names = array (
      0 => 'id',
      1 => 'first_name',
      2 => 'last_name',
      3 => 'email',
    );
    public static $mixin_classes = array (
    );
    protected $table = 'author';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\AuthorSchemaProxy;
    }
    public static function createRepo($write, $read)
    {
        return new \AuthorBooks\Model\AuthorBaseRepo($write, $read);
    }
    public function getId()
    {
        return intval($this->id);
    }
    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function getEmail()
    {
        return $this->email;
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
        return ["id" => $this->id, "first_name" => $this->first_name, "last_name" => $this->last_name, "email" => $this->email];
    }
    public function setData(array $data)
    {
        if (array_key_exists("id", $data)) { $this->id = $data["id"]; }
        if (array_key_exists("first_name", $data)) { $this->first_name = $data["first_name"]; }
        if (array_key_exists("last_name", $data)) { $this->last_name = $data["last_name"]; }
        if (array_key_exists("email", $data)) { $this->email = $data["email"]; }
    }
    public function clear()
    {
        $this->id = NULL;
        $this->first_name = NULL;
        $this->last_name = NULL;
        $this->email = NULL;
    }
}
