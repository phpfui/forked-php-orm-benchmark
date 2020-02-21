<?php
declare(strict_types=1);

namespace Image;

use Atlas\Mapper\RecordSet;

/**
 * @method ImageRecord offsetGet($offset)
 * @method ImageRecord appendNew(array $fields = [])
 * @method ImageRecord|null getOneBy(array $whereEquals)
 * @method ImageRecordSet getAllBy(array $whereEquals)
 * @method ImageRecord|null detachOneBy(array $whereEquals)
 * @method ImageRecordSet detachAllBy(array $whereEquals)
 * @method ImageRecordSet detachAll()
 * @method ImageRecordSet detachDeleted()
 */
class ImageRecordSet extends RecordSet
{
}
