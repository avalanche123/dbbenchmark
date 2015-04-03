Test report
===========

We launch a siege like that : siege -b -c10 -t5S http://local.dbbenchmark.com/1-write/cassandra-ext.php

1) Write

    cassandra via datastax extension  :  612 hits | 136.61 req/sec
    cassandra via thrift              :  960 hits | 205.13 req/sec
    cassandra via binary protocol     :  300 hits |  71.43 req/sec
    elasticsearch                     :  179 hits |  40.68 req/sec
    mysql                             :   22 hits |   5.34 req/sec

2) Read

    cassandra via datastax extension  :  345 hits |  82.18 req/sec
    cassandra via thrift              :  798 hits | 180.95 req/sec
    cassandra via binary protocol     :  259 hits |  61.67 req/sec
    elasticsearch                     :   99 hits |  23.80 req/sec
    mysql                             : 2856 hits | 667.29 req/sec

3) Read/Write

    cassandra via datastax extension  :  297 hits |  63.36 req/sec
    cassandra via thrift              :  463 hits | 103.81 req/sec
    cassandra via binary protocol     :  163 hits |  33.06 req/sec
    elasticsearch                     :   46 hits |  11.33 req/sec
    mysql                             :   22 hits |   5.02 req/sec

4) Scan

    cassandra via datastax extension  :  287 hits |  61.32 req/sec
    cassandra via thrift              :  171 hits |  40.52 req/sec
    cassandra via binary protocol     :   13 hits |   2.84 req/sec
    elasticsearch                     :  137 hits |  31.14 req/sec
    mysql                             : 1675 hits | 379.82 req/sec

