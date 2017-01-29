<?php
namespace AuthorBooks\Model;
use Maghead\Schema\RuntimeSchema;
use Maghead\Schema\RuntimeColumn;
use Maghead\Schema\Relationship\Relationship;
class BookSchemaProxy
    extends RuntimeSchema
{
    const schema_class = 'AuthorBooks\\Model\\BookSchema';
    const model_name = 'Book';
    const model_namespace = 'AuthorBooks\\Model';
    const COLLECTION_CLASS = 'AuthorBooks\\Model\\BookCollection';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Book';
    const PRIMARY_KEY = 'id';
    const TABLE = 'book';
    const LABEL = 'Book';
    public static $column_hash = array (
      'id' => 1,
      'title' => 1,
      'isbn' => 1,
      'price' => 1,
      'author_id' => 1,
    );
    public static $mixin_classes = array (
    );
    public $columnNames = array (
      0 => 'id',
      1 => 'title',
      2 => 'isbn',
      3 => 'price',
      4 => 'author_id',
    );
    public $primaryKey = 'id';
    public $columnNamesIncludeVirtual = array (
      0 => 'id',
      1 => 'title',
      2 => 'isbn',
      3 => 'price',
      4 => 'author_id',
    );
    public $label = 'Book';
    public $readSourceId = 'default';
    public $writeSourceId = 'default';
    public $relations;
    public function __construct()
    {
        $this->relations = array( 
      'author' => \Maghead\Schema\Relationship\BelongsTo::__set_state(array( 
      'data' => array( 
          'type' => 3,
          'self_schema' => 'AuthorBooks\\Model\\BookSchema',
          'self_column' => 'author_id',
          'foreign_schema' => 'AuthorBooks\\Model\\AuthorSchema',
          'foreign_column' => 'id',
        ),
      'accessor' => 'author',
      'where' => NULL,
      'orderBy' => array( 
        ),
      'onUpdate' => NULL,
      'onDelete' => NULL,
      'usingIndex' => NULL,
    )),
    );
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
        $this->columns[ 'title' ] = new RuntimeColumn('title',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 255,
        ),
      'name' => 'title',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 255,
    ));
        $this->columns[ 'isbn' ] = new RuntimeColumn('isbn',array( 
      'locales' => NULL,
      'attributes' => array( 
          'length' => 128,
          'immutable' => true,
          'unique' => true,
          'findable' => true,
        ),
      'name' => 'isbn',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'varchar',
      'isa' => 'str',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'length' => 128,
      'immutable' => true,
      'unique' => true,
      'findable' => true,
    ));
        $this->columns[ 'price' ] = new RuntimeColumn('price',array( 
      'locales' => NULL,
      'attributes' => array( 
          'default' => 0,
        ),
      'name' => 'price',
      'primary' => NULL,
      'unsigned' => NULL,
      'type' => 'float',
      'isa' => 'float',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
      'default' => 0,
    ));
        $this->columns[ 'author_id' ] = new RuntimeColumn('author_id',array( 
      'locales' => NULL,
      'attributes' => array( 
        ),
      'name' => 'author_id',
      'primary' => NULL,
      'unsigned' => true,
      'type' => 'int',
      'isa' => 'int',
      'notNull' => NULL,
      'enum' => NULL,
      'set' => NULL,
      'onUpdate' => NULL,
    ));
    }
}
