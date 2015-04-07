Test report
===========

To have the following metrics, we launched siege like that : siege -b -c10 -t5S http://local.dbbenchmark.com/1-write/cassandra-ext.php

Tests run on my own machine : Ubuntu 14.04.2 LTS 64 Bits, 16G Ram, Intel® Xeon(R) CPU E3-1270 v3 @ 3.50GHz × 8

I know, this is not a distant server... but metrics are usefull however...

To know more, see [how to install](docs/install.md)

Benchmark Results
----------------

1) Write

    cassandra via datastax extension  :  641 hits | 140.57 req/sec
    cassandra via thrift              : 1081 hits | 230.93 req/sec
    cassandra via binary protocol     :  325 hits |  69.59 req/sec
    elasticsearch                     :  285 hits |  58.64 req/sec
    mysql                             :   22 hits |   5.34 req/sec
    mariaDb                           :   25 hits |   5.64 req/sec

2) Read

    cassandra via datastax extension  :  664 hits | 156.54 req/sec
    cassandra via thrift              :  874 hits | 196.85 req/sec
    cassandra via binary protocol     :  260 hits |  61.90 req/sec
    elasticsearch                     :  160 hits |  33.33 req/sec
    mysql                             : 2856 hits | 667.29 req/sec
    mariaDb                           : 1280 hits | 285.47 req/sec

3) Read/Write

    cassandra via datastax extension  :  488 hits | 117.87 req/sec
    cassandra via thrift              :  488 hits | 111.42 req/sec
    cassandra via binary protocol     :  163 hits |  33.06 req/sec
    elasticsearch                     :  110 hits |  22.13 req/sec
    mysql                             :   22 hits |   5.02 req/sec
    mariaDb                           :   23 hits |   5.19 req/sec

4) Scan

    cassandra via datastax extension  :  325 hits |  66.60 req/sec
    cassandra via thrift              :  168 hits |  41.38 req/sec
    cassandra via binary protocol     :   13 hits |   2.84 req/sec
    elasticsearch                     :  122 hits |  29.90 req/sec
    mysql                             : 1675 hits | 379.82 req/sec
    mariaDb                           : 1672 hits | 362.82 req/sec

