<?php
declare(strict_types=1);

namespace Book;

use Atlas\Mapper\RecordSet;

/**
 * @method BookRecord offsetGet($offset)
 * @method BookRecord appendNew(array $fields = [])
 * @method BookRecord|null getOneBy(array $whereEquals)
 * @method BookRecordSet getAllBy(array $whereEquals)
 * @method BookRecord|null detachOneBy(array $whereEquals)
 * @method BookRecordSet detachAllBy(array $whereEquals)
 * @method BookRecordSet detachAll()
 * @method BookRecordSet detachDeleted()
 */
class BookRecordSet extends RecordSet
{
}
