<?php
declare(strict_types=1);

namespace Product;

use Atlas\Mapper\Record;

/**
 * @method ProductRow getRow()
 */
class ProductRecord extends Record
{
    use ProductFields;
}
