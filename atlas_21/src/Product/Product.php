<?php
declare(strict_types=1);

namespace Product;

use Atlas\Mapper\Mapper;
use Atlas\Table\Row;

/**
 * @method ProductTable getTable()
 * @method ProductRelationships getRelationships()
 * @method ProductRecord|null fetchRecord($primaryVal, array $with = [])
 * @method ProductRecord|null fetchRecordBy(array $whereEquals, array $with = [])
 * @method ProductRecord[] fetchRecords(array $primaryVals, array $with = [])
 * @method ProductRecord[] fetchRecordsBy(array $whereEquals, array $with = [])
 * @method ProductRecordSet fetchRecordSet(array $primaryVals, array $with = [])
 * @method ProductRecordSet fetchRecordSetBy(array $whereEquals, array $with = [])
 * @method ProductSelect select(array $whereEquals = [])
 * @method ProductRecord newRecord(array $fields = [])
 * @method ProductRecord[] newRecords(array $fieldSets)
 * @method ProductRecordSet newRecordSet(array $records = [])
 * @method ProductRecord turnRowIntoRecord(Row $row, array $with = [])
 * @method ProductRecord[] turnRowsIntoRecords(array $rows, array $with = [])
 */
class Product extends Mapper
{
}
