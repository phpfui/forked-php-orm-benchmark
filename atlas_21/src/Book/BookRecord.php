<?php
declare(strict_types=1);

namespace Book;

use Atlas\Mapper\Record;

/**
 * @method BookRow getRow()
 */
class BookRecord extends Record
{
    use BookFields;
}
