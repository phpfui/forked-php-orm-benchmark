# PHP ORM Benchmark

## 1. Methodology

I have created this test suite to test both the performance and DX for some of the ORMs that are out there. 

I have chosen a few tests that are not trivial (eg: inserting a single row) on a not-to-simple database structure:

1. **products**. Products belong to one category (many-to-one), have many morphed images (see table description below) and belongs to many tags (many-to-many)
2. **categories**
3. **tags**
5. **images**: this table is created to hold images for multiple type of entities via it's `imageable_type` column

The benchmark runs 500 times (a number that you can change in the `AbstractTestSuite` class) for the following operations:

1. **Insert** a product along with its related category, one image and 2 tags
2. **Update** a product that has its name changed, its category's name changed, its image's path changed and the name of one of the tags changed
3. **Find** a product by its ID
4. Run a **complex query** that counts the number of products joined with categories where there are some conditions on both the `products` and the `categories` table
5. Load 10 products and **eager-load** the related category, images and tags

**Note!** Previous version of the benchmark included PDO as a reference but I removed it since the operations have become more complex.

**Disclaimer!** I am also the author of the Sirius ORM.

## 2. Requirements

* linux or bsd system
* PHP 7.2 or greater
* pdo_sqlite

#### Running All The Benchmarks

    > cd /path/to/php-orm-benchmark
    > php TestRunner.php

#### Running One Of The Benchmarks

    > cd /path/to/atlas_21
    > php TestRunner.php

## 3. Results

The reference is the PDOTestSuite (the number of tests is adjusted to make raw
PDO score about 100 to each test). For the ORMs, the smaller score is the
better (i. e. the faster).

(updated 2019-Dec-26)

| Library                          | Insert | Update | Find   | Complex| EagerL. | memory usage|  time  |
| --------------------------------:| ------:| ------:| ------:| ------:| -------:| -----------:| ------:|
|                         AtlasOrm |   1687 |   1315 |    242 |    242 |    8405 |   7,923,952 |  12.00 |
|                         CycleOrm |  17250 |  32000 |    350 |      0 |       0 |   9,981,544 |  49.83 |
|      CycleOrmWithGeneratedMapper |  18588 |  34227 |    246 |      0 |       0 |  10,003,336 |  53.36 |
|                        DoctrineM |  17747 |  34091 |    560 |    302 |    6390 |  12,582,912 |  59.57 |
|               DoctrineMWithCache |  16390 |  34922 |    571 |    246 |    6511 |  12,582,912 |  58.97 |
|                         Eloquent |   3676 |   3020 |    675 |    971 |   10119 |   4,194,304 |  18.62 |
|             EloquentWithoutEvent |   3458 |   2457 |    537 |    663 |    8800 |   4,194,304 |  16.04 |
|                        SiriusOrm |   1858 |   1413 |    268 |    288 |    8463 |   3,727,744 |  12.35 |


For running benchmarks using the Docker shell see [.docker-stack/README.md](./.docker-stack/README.md)

Comments/things to mention about the results. Please understand I'm not proficient in most of the libraries in this test so I might have missed something.

#### Atlas ORM
- As implemented test is not a full-blown Data Mapper in the sense that it does not generate domain entities but internal objects called `Record` and `RecordSet`. 
  To make it generate domain entities one needs to use `Atlas\Transit`. However the `Record` objects provided by Atlas can be easily augmented to improve their functionality enough for most applications
- **Bug 1**: doesn't save the second tag associated with a product
- **Bug 2**: the `persist()` method doesn't work as advertised for new Records so I had to use INSERTs
- This ORM stores the rows retrieved in an Storage object and fetching by ID doesn't necessarily executes the SQL so I had to alter the source code to by-pass the storage (`Mapper` line 63)

#### Cycle ORM
- has some columns with missing data because I couldn't make those operations work as the rest of the libraries.
- **Important note!** For this particular library I have observed an exponential increase in time execution with the number of runs. Doing 500 inserts takes about 10 times more than inserting 100.

#### Doctrine ORM
- the numbers are skewed on the "find" test because I had to set all relations as eager-loaded so that the "relations" test work as the rest. I would expect lower numbers for find
- since Doctrine uses an Entity Manager I had to do a lot of `$em->clear()` to make it for a level playing field

#### Eloquent
- seems to be the most stable one in terms of memory consumption (increasing the number of runs doesn't increase the memory consumed). I think this is to be expected. 
Since it's an Active Record implementation and all objects know about everything, the library doesn't have to compile intermediary objects for various operations (eg: retrieving related entities). 

#### Sirius ORM
- as stated above, I'm the author. However the library doesn't have cache-ing mechanism or any other performance enhancement options (eg: generating Proxy classes). It also doesn't have an event manager or an entity manager. I would say that in
 terms of capabilities is closest to Eloquent (the version without events).

## 4. Contributions

If you are the developer or user of an ORM, data mapper, Active Record library and you want to have it included in this repo, please send a pull-request.

If you see something wrong about the current usage of one of the libraries, please send a pull-request along with a short explanation of what that change does.

Please, try to implement the solutions using the most common configuration. If you want to include an optimized version of the test, create another one in the same folder, like that in the Cycle Orm folder.