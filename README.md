Rapport de test
===============

On lance un siege comme suit : siege -b -c10 -t5S http://local.dbbenchmark.com/1-write/cassandra.php

1) Write

    cassandra via thrift           :  940 hits | 215.10 req/sec
    cassandra via binary protocol  :  300 hits |  71.43 req/sec
    elasticsearch                  :  179 hits |  40.68 req/sec 
    mysql                          :   22 hits |   5.34 req/sec

2) Read

    cassandra via thrift           :  798 hits | 180.95 req/sec
    cassandra via binary protocol  :  259 hits |  61.67 req/sec
    elasticsearch                  :   99 hits |  23.80 req/sec
    mysql                          : 2856 hits | 667.29 req/sec

3) Read/Write

    cassandra via thrift           :  463 hits | 103.81 req/sec
    cassandra via binary protocol  :  163 hits |  33.06 req/sec
    elasticsearch                  :   46 hits |  11.33 req/sec
    mysql                          :   22 hits |   5.02 req/sec

4) Scan

    cassandra via thrift           :  171 hits |  40.52 req/sec
    cassandra via binary protocol  :   13 hits |   2.84 req/sec
    elasticsearch                  :  137 hits |  31.14 req/sec
    mysql                          : 1675 hits | 379.82 req/sec

