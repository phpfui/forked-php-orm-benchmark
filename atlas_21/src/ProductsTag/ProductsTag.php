<?php
declare(strict_types=1);

namespace ProductsTag;

use Atlas\Mapper\Mapper;
use Atlas\Table\Row;

/**
 * @method ProductsTagTable getTable()
 * @method ProductsTagRelationships getRelationships()
 * @method ProductsTagRecord|null fetchRecord($primaryVal, array $with = [])
 * @method ProductsTagRecord|null fetchRecordBy(array $whereEquals, array $with = [])
 * @method ProductsTagRecord[] fetchRecords(array $primaryVals, array $with = [])
 * @method ProductsTagRecord[] fetchRecordsBy(array $whereEquals, array $with = [])
 * @method ProductsTagRecordSet fetchRecordSet(array $primaryVals, array $with = [])
 * @method ProductsTagRecordSet fetchRecordSetBy(array $whereEquals, array $with = [])
 * @method ProductsTagSelect select(array $whereEquals = [])
 * @method ProductsTagRecord newRecord(array $fields = [])
 * @method ProductsTagRecord[] newRecords(array $fieldSets)
 * @method ProductsTagRecordSet newRecordSet(array $records = [])
 * @method ProductsTagRecord turnRowIntoRecord(Row $row, array $with = [])
 * @method ProductsTagRecord[] turnRowsIntoRecords(array $rows, array $with = [])
 */
class ProductsTag extends Mapper
{
}
