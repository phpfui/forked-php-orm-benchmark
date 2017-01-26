<?php
namespace AuthorBooks\Model;
use Maghead\Schema;

class BookSchema extends Schema
{
    public function schema()
    {
        $this->column('title')
            ->varchar(255);

        $this->column('isbn')
            ->varchar(128)
            ->immutable()
            ->unique()
            ->findable()
            ;

        $this->column('price')
            ->float()
            ->default(0)
            ;

        $this->column('author_id')
            ->integer()
            ->unsigned()
            ;

        $this->table('book');

        $this->belongsTo('author','AuthorBooks\Model\AuthorSchema', 'id', 'author_id');
    }

}
