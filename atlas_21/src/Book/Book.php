<?php
declare(strict_types=1);

namespace Book;

use Atlas\Mapper\Mapper;
use Atlas\Table\Row;

/**
 * @method BookTable getTable()
 * @method BookRelationships getRelationships()
 * @method BookRecord|null fetchRecord($primaryVal, array $with = [])
 * @method BookRecord|null fetchRecordBy(array $whereEquals, array $with = [])
 * @method BookRecord[] fetchRecords(array $primaryVals, array $with = [])
 * @method BookRecord[] fetchRecordsBy(array $whereEquals, array $with = [])
 * @method BookRecordSet fetchRecordSet(array $primaryVals, array $with = [])
 * @method BookRecordSet fetchRecordSetBy(array $whereEquals, array $with = [])
 * @method BookSelect select(array $whereEquals = [])
 * @method BookRecord newRecord(array $fields = [])
 * @method BookRecord[] newRecords(array $fieldSets)
 * @method BookRecordSet newRecordSet(array $records = [])
 * @method BookRecord turnRowIntoRecord(Row $row, array $with = [])
 * @method BookRecord[] turnRowsIntoRecords(array $rows, array $with = [])
 */
class Book extends Mapper
{
}
