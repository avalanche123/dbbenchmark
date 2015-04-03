<?php

require __DIR__ . '/../../vendor/autoload.php';

use cassandra\Connection;

$cassandra = new Connection('thrift', '127.0.0.1');

$resultat = $cassandra->execute_cql3_query("SELECT * FROM user limit 5000");

var_dump(count($resultat->rows));   