Requirements
------------

* linux or bsd system
* PHP 5.3 or greater
* pdo_sqlite

Running All The Benchmarks
--------------------------

    > cd /path/to/php-orm-benchmark
    > php TestRunner.php

Running One Of The Benchmarks
-----------------------------

    > cd /path/to/atlas_21
    > php TestRunner.php

Test Scenarios
--------------

1. Mass insertion: Tests model objects and save() operations.

2. Retrieve By Pk: Tests basic hydration

3. Complex Query an OR but no hydration: Tests Query parsing

4. Basic Query with 5 results: Tests hydration and collections

5. Query with join: Tests join hydration


Results
-------

The reference is the PDOTestSuite (the number of tests is adjusted to make raw
PDO score about 100 to each test). For the ORMs, the smaller score is the
better (i. e. the faster).

## PHP CLI 7.2.0

(updated 2019-Dec-26)

|-------------------------------------------------------------------------------------------------------|
| Library                          | Insert | findPk | complex| hydrate|  with  | memory usage |  time  |
| --------------------------------:| ------:| ------:| ------:| ------:| ------:| ------------:| ------:|
|                              PDO |     22 |      3 |      8 |     52 |    136 |    1,674,776 |   0.23 |
|-------------------------------------------------------------------------------------------------------|
|                         AtlasOrm |    240 |     39 |    267 |    202 |    176 |   12,160,896 |   0.98 |
|-------------------------------------------------------------------------------------------------------|
|                         CycleOrm |    410 |    177 |    347 |    387 |    839 |   14,245,168 |   2.23 |
|-------------------------------------------------------------------------------------------------------|
|                          PHPixie |    598 |     74 |    342 |    185 |    256 |    7,906,272 |   1.47 |
|-------------------------------------------------------------------------------------------------------|
|                        DoctrineM |    189 |     37 |    303 |    315 |    267 |   18,874,368 |   1.22 |
|               DoctrineMWithCache |    201 |     37 |    260 |    259 |    226 |   18,874,368 |   1.09 |
|            DoctrineMArrayHydrate |    197 |     42 |    250 |    117 |    130 |   16,777,216 |   0.84 |
|           DoctrineMScalarHydrate |    194 |     37 |    241 |    107 |    112 |   16,777,216 |   0.79 |
|          DoctrineMWithoutProxies |    206 |     39 |    302 |    152 |    336 |   18,874,368 |   1.14 |
|-------------------------------------------------------------------------------------------------------|
|                         Eloquent |    528 |     60 |    279 |    220 |    356 |   12,582,912 |   1.48 |
|             EloquentWithoutEvent |    507 |     80 |    320 |    152 |    311 |   12,582,912 |   1.40 |
|-------------------------------------------------------------------------------------------------------|

Running benchmarks using the Docker shell
-----------------------------------------

See [.docker-stack/README.md](./.docker-stack/README.md)
