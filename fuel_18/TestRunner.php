<?php

passthru('php '.dirname(__FILE__).'/TestRunner_WithoutCache.php');
passthru('php '.dirname(__FILE__).'/TestRunner_WithCache.php');
