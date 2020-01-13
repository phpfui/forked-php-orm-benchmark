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
|                              PDO |     16 |      2 |      9 |    133 |    168 |    1,674,776 |   0.34 |
|-------------------------------------------------------------------------------------------------------|
|                         AtlasOrm |    343 |     84 |    250 |    502 |    203 |   12,160,896 |   1.48 |
|-------------------------------------------------------------------------------------------------------|
|                         CycleOrm |    292 |    121 |    268 |    910 |    648 |   14,246,976 |   2.30 |
|      CycleOrmWithGeneratedMapper |    582 |    191 |    332 |    767 |    473 |   16,343,824 |   2.45 |
|-------------------------------------------------------------------------------------------------------|
|                          PHPixie |   1214 |    103 |    374 |    474 |    224 |    7,906,272 |   2.43 |
|-------------------------------------------------------------------------------------------------------|
|                        DoctrineM |    202 |     72 |    326 |   1151 |    190 |   18,874,368 |   2.50 |
|               DoctrineMWithCache |    200 |     38 |    247 |   1121 |    185 |   18,874,368 |   1.89 |
|            DoctrineMArrayHydrate |    179 |     39 |    259 |    425 |    121 |   16,777,216 |   1.13 |
|           DoctrineMScalarHydrate |    176 |     42 |    247 |    313 |    112 |   16,777,216 |   0.99 |
|          DoctrineMWithoutProxies |    181 |     41 |    243 |    722 |    260 |   18,874,368 |   1.55 |
|-------------------------------------------------------------------------------------------------------|
|                         Eloquent |    652 |     85 |    351 |    544 |    335 |   12,582,912 |   2.13 |
|             EloquentWithoutEvent |    468 |     74 |    273 |    355 |    313 |   12,582,912 |   1.51 |



Running benchmarks using the Docker shell
-----------------------------------------

See [.docker-stack/README.md](./.docker-stack/README.md)
