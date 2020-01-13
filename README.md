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
|                              PDO |     25 |      5 |     12 |    177 |    215 |    1,674,776 |   0.44 |
|-------------------------------------------------------------------------------------------------------|
|                         AtlasOrm |    378 |     38 |    235 |    451 |    173 |   12,160,896 |   1.29 |
|-------------------------------------------------------------------------------------------------------|
|                         CycleOrm |    296 |     65 |    130 |    798 |    253 |   14,246,992 |   1.58 |
|      CycleOrmWithGeneratedMapper |    271 |     60 |    156 |    458 |    228 |   16,343,840 |   1.21 |
|-------------------------------------------------------------------------------------------------------|
|                          PHPixie |    532 |     52 |    294 |    484 |    215 |    7,906,272 |   1.59 |
|-------------------------------------------------------------------------------------------------------|
|                        DoctrineM |    219 |     47 |    292 |   1229 |    176 |   18,874,368 |   2.09 |
|               DoctrineMWithCache |    177 |     40 |    252 |   1131 |    180 |   18,874,368 |   1.88 |
|            DoctrineMArrayHydrate |    178 |     39 |    257 |    419 |    139 |   16,777,216 |   1.13 |
|           DoctrineMScalarHydrate |    178 |     38 |    251 |    286 |    136 |   16,777,216 |   0.99 |
|          DoctrineMWithoutProxies |    173 |     38 |    243 |    712 |    265 |   18,874,368 |   1.53 |
|-------------------------------------------------------------------------------------------------------|
|                         Eloquent |    585 |     62 |    277 |    502 |    355 |   12,582,912 |   1.81 |
|             EloquentWithoutEvent |    464 |     58 |    302 |    355 |    307 |   12,582,912 |   1.52 |
|-------------------------------------------------------------------------------------------------------|



Running benchmarks using the Docker shell
-----------------------------------------

See [.docker-stack/README.md](./.docker-stack/README.md)
