<?php

class Book extends ActiveRecord\Model
{
    public static $table_name = 'book';
    static $attr_accessible = array('title','author_id');

		static $belongs_to = array(
			array('author')
		);

}
