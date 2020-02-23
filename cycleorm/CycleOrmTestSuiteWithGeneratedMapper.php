<?php

require_once __DIR__ . '/../AbstractTestSuite.php';
require_once __DIR__ . '/CycleOrmTestSuite.php';

class CycleOrmTestSuiteWithGeneratedMapper extends CycleOrmTestSuite
{
    protected const PRODUCT_MAPPER  = GeneratedProductMapper::class;
    protected const CATEGORY_MAPPER = GeneratedCategoryMapper::class;
    protected const TAG_MAPPER      = GeneratedTagMapper::class;
    protected const IMAGE_MAPPER    = GeneratedImageMapper::class;
}
