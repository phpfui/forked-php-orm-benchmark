<?php
echo "|-------------------------------------------------------------------------------------------------------|\n";
echo "| Library                          | Insert | findPk | complex| hydrate|  with  | memory usage |  time  |\n";
echo "| --------------------------------:| ------:| ------:| ------:| ------:| ------:| ------------:| ------:|\n";

$separator = "|-------------------------------------------------------------------------------------------------------|\n";

passthru('php raw_pdo/TestRunner.php');
echo $separator;
passthru('php atlas_21/TestRunner.php');
echo $separator;
passthru('php cycleorm/TestRunner.php');
echo $separator;
passthru('php phpixie/TestRunner.php');
echo $separator;
passthru('php doctrine_m/TestRunner.php');
echo $separator;
passthru('php eloquent/TestRunner.php');
echo "|-------------------------------------------------------------------------------------------------------|\n";
