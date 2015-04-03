How to Install
==============

I ran this benchmark with php-fpm 5.6, nginx, cassandra 2.0, elasticsearch 1.5, mysql 5.6 and MariaDb 10.0.17

You could find my nginx conf [here](nginx.conf).
You just have to configure your vhost to point on web/ directory.

I installed 3 cassandra drivers
- Cassandra extension (from Datastax). [Instruction here](https://github.com/datastax/php-driver)
- Cassandra with Thrift extension. [Instruction here](thrift.md)
- Cassandra with binary protocol. This one is install with composer, but if you want to see it in detail, [go here](https://github.com/evseevnn/php-cassandra-binary)

Then, you have to install and launch Cassandra. Please refer to the doc on http://planetcassandra.org/cassandra/

Do the same for elasticsearch (extremely simple to install), mysql and mariaDb (for this one, you'd probably not enable to run mysql and mariaDB in the same time... So you have to launch benchmark with mysql first, and remove it to install mariaDb).

Finally, run 
```
composer update
```

Benchmark !
-----------

For your metrics, you could use whatever you want (jMeter, siege...). But first, launch this :
http://local.dbbenchmark.com/prepareDBs.php

This script drop and create all tables, database, keyspace, index you need.


Finally, you have to test these following urls :

http://local.dbbenchmark.com/1-write/cassandra-ext.php  
http://local.dbbenchmark.com/1-write/cassandra-thrift.php  
http://local.dbbenchmark.com/1-write/cassandra-binary.php  
http://local.dbbenchmark.com/1-write/elasticsearch.php  
http://local.dbbenchmark.com/1-write/mysql.php  
  
http://local.dbbenchmark.com/2-read/cassandra-ext.php  
http://local.dbbenchmark.com/2-read/cassandra-thrift.php    
http://local.dbbenchmark.com/2-read/cassandra-binary.php  
http://local.dbbenchmark.com/2-read/elasticsearch.php  
http://local.dbbenchmark.com/2-read/mysql.php  

http://local.dbbenchmark.com/3-read-write/cassandra-ext.php  
http://local.dbbenchmark.com/3-read-write/cassandra-thrift.php  
http://local.dbbenchmark.com/3-read-write/cassandra-binary.php  
http://local.dbbenchmark.com/3-read-write/elasticsearch.php  
http://local.dbbenchmark.com/3-read-write/mysql.php  

http://local.dbbenchmark.com/4-scan/cassandra-ext.php  
http://local.dbbenchmark.com/4-scan/cassandra-thrift.php  
http://local.dbbenchmark.com/4-scan/cassandra-binary.php  
http://local.dbbenchmark.com/4-scan/elasticsearch.php  
http://local.dbbenchmark.com/4-scan/mysql.php  

Here we go. Have fun !
