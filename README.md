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
|                              PDO |     28 |     15 |     20 |    175 |     77 |    1,664,384 |   0.32 |
|                         AtlasOrm |    675 |    388 |    409 |   3802 |    817 |    7,957,416 |   6.10 |
|                         CycleOrm |   1301 |    568 |    516 |   8064 |   1212 |   10,041,880 |  11.70 |
|      CycleOrmWithGeneratedMapper |   1039 |    676 |    519 |   3797 |   1106 |   12,138,728 |   7.18 |
|                        DoctrineM |    627 |    419 |    428 |   7320 |    727 |   12,582,912 |   9.63 |
|               DoctrineMWithCache |    629 |    364 |    468 |   6903 |    773 |   12,582,912 |   9.26 |
|            DoctrineMArrayHydrate |    657 |    366 |    434 |   2619 |    528 |   12,582,912 |   4.72 |
|           DoctrineMScalarHydrate |    653 |    364 |    522 |   1949 |    446 |   12,582,912 |   4.05 |
|          DoctrineMWithoutProxies |    685 |    357 |    459 |   4333 |    756 |   12,582,912 |   6.72 |
|                         Eloquent |   1930 |    832 |    758 |   3621 |   1788 |    8,388,608 |   8.97 |
|             EloquentWithoutEvent |   1771 |    827 |    748 |   2486 |   1751 |    8,388,608 |   7.62 |




Running benchmarks using the Docker shell
-----------------------------------------

See [.docker-stack/README.md](./.docker-stack/README.md)
