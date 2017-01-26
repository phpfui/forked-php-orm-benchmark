<?php
namespace AuthorBooks\Model;
use Maghead\Schema\RuntimeSchema;
use Maghead\Schema\RuntimeColumn;
use Maghead\Schema\Relationship\Relationship;
class AuthorSchemaProxy
    extends RuntimeSchema
{
    const schema_class = 'AuthorBooks\\Model\\AuthorSchema';
    const model_name = 'Author';
    const model_namespace = 'AuthorBooks\\Model';
    const COLLECTION_CLASS = 'AuthorBooks\\Model\\AuthorCollection';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Author';
    const PRIMARY_KEY = 'id';
    const TABLE = 'author';
    const LABEL = 'Author';
    public static $column_hash = array (
      'id' => 1,
      'first_name' => 1,
      'last_name' => 1,
      'email' => 1,
    );
    public static $mixin_classes = array (
    );
    public $columnNames = array (
      0 => 'id',
      1 => 'first_name',
      2 => 'last_name',
      3 => 'email',
    );
    public $primaryKey = 'id';
    public $columnNamesIncludeVirtual = array (
      0 => 'id',
      1 => 'first_name',
      2 => 'last_name',
      3 => 'email',
    );
    public $label = 'Author';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public $relations;
    public function __construct()
    {
        $this->columns[ 'id' ] = new RuntimeColumn('id',array( 
      'locales' => NULL,
      'attributes' => array( 
          'autoIncrement' => true,
          'renderAs' => 'HiddenInput',
          'widgetAttributes' => array( 
            ),
        ),
      'name' => 'id',
      'primary' => true,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'autoIncrement' => true,
      'renderAs' => 'HiddenInput',
      'widgetAttributes' => array( 
        ),
    ));
        $this->columns[ 'first_name' ] = new RuntimeColumn('first_name',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 128,
          'findable' => true,
        ),
      'name' => 'first_name',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 128,
      'findable' => true,
    ));
        $this->columns[ 'last_name' ] = new RuntimeColumn('last_name',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 128,
          'findable' => true,
        ),
      'name' => 'last_name',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 128,
      'findable' => true,
    ));
        $this->columns[ 'email' ] = new RuntimeColumn('email',array( 
      'locales' => NULL,
      'attributes' => array( 
          'required' => true,
          'findable' => true,
          'length' => 128,
        ),
      'name' => 'email',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => true,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'required' => true,
      'findable' => true,
      'length' => 128,
    ));
    }
}
