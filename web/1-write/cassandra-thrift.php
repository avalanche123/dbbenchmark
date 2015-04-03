<?php

require __DIR__ . '/../../vendor/autoload.php';

use cassandra\Connection;

$cassandra = new Connection('thrift', '127.0.0.1');

for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $cassandra->execute_cql3_query("INSERT INTO user (id, fname, lname, description) VALUES ($id, '".$fname."', '".$lname."', '".$description."')");
}

var_dump($index);