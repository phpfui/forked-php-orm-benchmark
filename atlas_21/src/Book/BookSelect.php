<?php
declare(strict_types=1);

namespace Book;

use Atlas\Mapper\MapperSelect;

/**
 * @method BookRecord|null fetchRecord()
 * @method BookRecord[] fetchRecords()
 * @method BookRecordSet fetchRecordSet()
 */
class BookSelect extends MapperSelect
{
}
