<?php
declare(strict_types=1);

namespace Image;

use Atlas\Mapper\Mapper;
use Atlas\Table\Row;

/**
 * @method ImageTable getTable()
 * @method ImageRelationships getRelationships()
 * @method ImageRecord|null fetchRecord($primaryVal, array $with = [])
 * @method ImageRecord|null fetchRecordBy(array $whereEquals, array $with = [])
 * @method ImageRecord[] fetchRecords(array $primaryVals, array $with = [])
 * @method ImageRecord[] fetchRecordsBy(array $whereEquals, array $with = [])
 * @method ImageRecordSet fetchRecordSet(array $primaryVals, array $with = [])
 * @method ImageRecordSet fetchRecordSetBy(array $whereEquals, array $with = [])
 * @method ImageSelect select(array $whereEquals = [])
 * @method ImageRecord newRecord(array $fields = [])
 * @method ImageRecord[] newRecords(array $fieldSets)
 * @method ImageRecordSet newRecordSet(array $records = [])
 * @method ImageRecord turnRowIntoRecord(Row $row, array $with = [])
 * @method ImageRecord[] turnRowsIntoRecords(array $rows, array $with = [])
 */
class Image extends Mapper
{
}
