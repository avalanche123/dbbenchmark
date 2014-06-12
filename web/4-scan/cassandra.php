<?php

require __DIR__ . '/../../vendor/autoload.php';

use cassandra\Connection;

$con = new Connection('mykeyspace', '127.0.0.1');
$res = $con->prepare_cql3_query("SELECT * FROM users WHERE fname = ?");
$res = $con->execute_prepared_cql3_query($res->itemId, array('toto'));

var_dump($res);