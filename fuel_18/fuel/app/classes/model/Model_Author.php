<?php
class Model_Author extends Orm\Model
{
    protected static $_table_name = 'author';
    protected static $_primary_key = array('id');
    protected static $_properties = array('id', 'first_name', 'last_name', 'email');

    protected static $_has_many = array(
        'books' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Book',
            'key_to' => 'author_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}