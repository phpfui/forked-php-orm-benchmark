<?php
class Model_Book extends Orm\Model
{
    protected static $_table_name = 'book';
    protected static $_primary_key = array('id');
    protected static $_properties = array('id', 'title', 'isbn', 'price', 'author_id');

    protected static $_has_one = array(
        'author' => array(
            'key_from' => 'author_id',
            'model_to' => 'Model_Author',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );
}