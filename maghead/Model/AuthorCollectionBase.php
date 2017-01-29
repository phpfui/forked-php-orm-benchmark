<?php
namespace AuthorBooks\Model;
use Maghead\BaseCollection;
class AuthorCollectionBase
    extends BaseCollection
{
    const SCHEMA_PROXY_CLASS = 'AuthorBooks\\Model\\AuthorSchemaProxy';
    const MODEL_CLASS = 'AuthorBooks\\Model\\Author';
    const TABLE = 'author';
    const READ_SOURCE_ID = 'default';
    const WRITE_SOURCE_ID = 'default';
    const PRIMARY_KEY = 'id';
    public static function getSchema()
    {
        static $schema;
        if ($schema) {
           return $schema;
        }
        return $schema = new \AuthorBooks\Model\AuthorSchemaProxy;
    }
}
