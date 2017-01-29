<?php
namespace AuthorBooks\Model;
require_once __DIR__ . '/AuthorSchemaProxy.php';
use Maghead\Schema\SchemaLoader;
use Maghead\Result;
use Maghead\BaseModel;
use Maghead\Inflator;
use SQLBuilder\Bind;
use SQLBuilder\ArgumentArray;
use PDO;
use SQLBuilder\Universal\Query\InsertQuery;
use Maghead\BaseRepo;
class AuthorBaseRepo
    extends BaseRepo
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
    const FIND_BY_PRIMARY_KEY_SQL = 'SELECT * FROM author WHERE id = ? LIMIT 1';
    const LOAD_BY_FIRST_NAME_SQL = 'SELECT * FROM author WHERE first_name = :first_name LIMIT 1';
    const LOAD_BY_LAST_NAME_SQL = 'SELECT * FROM author WHERE last_name = :last_name LIMIT 1';
    const LOAD_BY_EMAIL_SQL = 'SELECT * FROM author WHERE email = :email LIMIT 1';
    const DELETE_BY_PRIMARY_KEY_SQL = 'DELETE FROM author WHERE id = ?';
    public static $columnNames = array (
      0 => 'id',
      1 => 'first_name',
      2 => 'last_name',
      3 => 'email',
    );
    public static $columnHash = array (
      'id' => 1,
      'first_name' => 1,
      'last_name' => 1,
      'email' => 1,
    );
    public static $mixinClasses = array (
    );
    protected $table = 'author';
    protected $loadStm;
    protected $deleteStm;
    protected $loadByFirstNameStm;
    protected $loadByLastNameStm;
    protected $loadByEmailStm;
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\AuthorSchemaProxy;
    }
    public function loadByPrimaryKey($pkId)
    {
        if (!$this->loadStm) {
           $this->loadStm = $this->read->prepare(self::FIND_BY_PRIMARY_KEY_SQL);
           $this->loadStm->setFetchMode(PDO::FETCH_CLASS, 'AuthorBooks\Model\Author');
        }
        return static::_stmFetchOne($this->loadStm, [$pkId]);
    }
    public function loadByFirstName($value)
    {
        if (!$this->loadByFirstNameStm) {
            $this->loadByFirstNameStm = $this->read->prepare(self::LOAD_BY_FIRST_NAME_SQL);
            $this->loadByFirstNameStm->setFetchMode(PDO::FETCH_CLASS, '\AuthorBooks\Model\Author');
        }
        return static::_stmFetchOne($this->loadByFirstNameStm, [':first_name' => $value ]);
    }
    public function loadByLastName($value)
    {
        if (!$this->loadByLastNameStm) {
            $this->loadByLastNameStm = $this->read->prepare(self::LOAD_BY_LAST_NAME_SQL);
            $this->loadByLastNameStm->setFetchMode(PDO::FETCH_CLASS, '\AuthorBooks\Model\Author');
        }
        return static::_stmFetchOne($this->loadByLastNameStm, [':last_name' => $value ]);
    }
    public function loadByEmail($value)
    {
        if (!$this->loadByEmailStm) {
            $this->loadByEmailStm = $this->read->prepare(self::LOAD_BY_EMAIL_SQL);
            $this->loadByEmailStm->setFetchMode(PDO::FETCH_CLASS, '\AuthorBooks\Model\Author');
        }
        return static::_stmFetchOne($this->loadByEmailStm, [':email' => $value ]);
    }
    public function deleteByPrimaryKey($pkId)
    {
        if (!$this->deleteStm) {
           $this->deleteStm = $this->write->prepare(self::DELETE_BY_PRIMARY_KEY_SQL);
        }
        return $this->deleteStm->execute([$pkId]);
    }
}
