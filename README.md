Test report
===========

First of all, see [how to install](docs/install.md)

We launch a siege like that : siege -b -c10 -t5S http://local.dbbenchmark.com/1-write/cassandra-ext.php

1) Write

    cassandra via datastax extension  :  612 hits | 136.61 req/sec
    cassandra via thrift              :  960 hits | 205.13 req/sec
    cassandra via binary protocol     :  300 hits |  71.43 req/sec
    elasticsearch                     :  285 hits |  58.64 req/sec
    mysql                             :   22 hits |   5.34 req/sec
    mariaDb                           :   25 hits |   5.64 req/sec

2) Read

    cassandra via datastax extension  :  345 hits |  82.18 req/sec
    cassandra via thrift              :  798 hits | 180.95 req/sec
    cassandra via binary protocol     :  259 hits |  61.67 req/sec
    elasticsearch                     :  160 hits |  33.33 req/sec
    mysql                             : 2856 hits | 667.29 req/sec
    mariaDb                           : 1280 hits | 285.47 req/sec

3) Read/Write

    cassandra via datastax extension  :  297 hits |  63.36 req/sec
    cassandra via thrift              :  463 hits | 103.81 req/sec
    cassandra via binary protocol     :  163 hits |  33.06 req/sec
    elasticsearch                     :  110 hits |  22.13 req/sec
    mysql                             :   22 hits |   5.02 req/sec
    mariaDb                           :   23 hits |   5.19 req/sec

4) Scan

    cassandra via datastax extension  :  287 hits |  61.32 req/sec
    cassandra via thrift              :  171 hits |  40.52 req/sec
    cassandra via binary protocol     :   13 hits |   2.84 req/sec
    elasticsearch                     :  122 hits |  29.90 req/sec
    mysql                             : 1675 hits | 379.82 req/sec
    mariaDb                           : 1672 hits | 362.82 req/sec

