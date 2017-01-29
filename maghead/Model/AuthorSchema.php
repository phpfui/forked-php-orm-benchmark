<?php
namespace AuthorBooks\Model;
use Maghead\Schema;

class AuthorSchema extends Schema
{
    public function schema()
    {
        $this->column('first_name')
            ->varchar(128)
            ->findable()
            ;

        $this->column('last_name')
            ->varchar(128)
            ->findable()
            ;

        $this->column('email')
            ->required()
            ->findable()
            ->varchar(128);

        $this->table('author');
    }
}
