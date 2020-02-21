<?php
echo "|-------------------------------------------------------------------------------------------------------|\n";
echo "| Library                          | Insert | Update | Find   | Complex| EagerL. | memory usage|  time  |\n";
echo "| --------------------------------:| ------:| ------:| ------:| ------:| -------:| -----------:| ------:|\n";

$separator = "|-------------------------------------------------------------------------------------------------------|\n";

passthru('php atlas_21/TestRunner.php');
echo $separator;
passthru('php cycleorm/TestRunner.php');
echo $separator;
passthru('php doctrine_m/TestRunner.php');
echo $separator;
passthru('php eloquent/TestRunner.php');
echo $separator;
passthru('php siriusorm/TestRunner.php');
echo "|-------------------------------------------------------------------------------------------------------|\n";
