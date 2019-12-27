Requirements
------------

* linux or bsd system
* PHP 7.2 or greater
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

| Library                          | Insert | findPk | complex| hydrate|  with  | memory usage |  time  |
| --------------------------------:| ------:| ------:| ------:| ------:| ------:| ------------:| ------:|
|                              PDO |     17 |      2 |      7 |    120 |    163 |    1,674,776 |   0.31 |
|                         AtlasOrm |    266 |     38 |    290 |    537 |    168 |   12,160,896 |   1.36 |
|                         CycleOrm |    459 |    150 |    325 |   1767 |    870 |   14,247,280 |   3.63 |
|                          PHPixie |    523 |     52 |    352 |    522 |    235 |    7,906,272 |   1.69 |
|                        DoctrineM |    230 |     40 |    294 |   1206 |    185 |   18,874,368 |   2.07 |
|               DoctrineMWithCache |    218 |     48 |    303 |   1209 |    189 |   18,874,368 |   2.08 |
|            DoctrineMArrayHydrate |    218 |     56 |    278 |    414 |    135 |   16,777,216 |   1.20 |
|           DoctrineMScalarHydrate |    248 |     38 |    278 |    302 |    115 |   16,777,216 |   1.09 |
|          DoctrineMWithoutProxies |    219 |     44 |    299 |    736 |    295 |   18,874,368 |   1.71 |
|                         Eloquent |    599 |     60 |    273 |    482 |    367 |   12,582,912 |   1.81 |
|             EloquentWithoutEvent |    507 |     60 |    314 |    388 |    312 |   12,582,912 |   1.62 |


Running benchmarks using the Docker shell
-----------------------------------------

See [.docker-stack/README.md](./.docker-stack/README.md)
