<?php
declare(strict_types=1);

namespace Category;

use Atlas\Mapper\Record;

/**
 * @method CategoryRow getRow()
 */
class CategoryRecord extends Record
{
    use CategoryFields;
}
