<?php

require dirname(__FILE__) . '/MagheadTestSuite.php';

$time = microtime(true);
$memory = memory_get_usage(true);
$test = new MagheadTestSuite();
$test->initialize();
$test->run();
echo sprintf(" %11s | %6.2f |\n", number_format(memory_get_usage(true) - $memory), (microtime(true) - $time));
