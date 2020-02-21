<?php
declare(strict_types=1);

namespace Product;

use Atlas\Mapper\RecordSet;

/**
 * @method ProductRecord offsetGet($offset)
 * @method ProductRecord appendNew(array $fields = [])
 * @method ProductRecord|null getOneBy(array $whereEquals)
 * @method ProductRecordSet getAllBy(array $whereEquals)
 * @method ProductRecord|null detachOneBy(array $whereEquals)
 * @method ProductRecordSet detachAllBy(array $whereEquals)
 * @method ProductRecordSet detachAll()
 * @method ProductRecordSet detachDeleted()
 */
class ProductRecordSet extends RecordSet
{
}
