<?php

require __DIR__ . '/../../vendor/autoload.php';

use cassandra\Connection;

$cassandra = new Connection('test', '127.0.0.1');

$res = array();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $cassandra->execute_cql3_query("INSERT INTO user (id, fname, lname, description) VALUES ($id, '".$fname."', '".$lname."', '".$description."')");
    $id = rand(0, 1000000);
    $resultat = $cassandra->execute_cql3_query("SELECT * FROM user WHERE id = $id");
    if($resultat->rows){
       $res[] =  $resultat;
    }
}

var_dump($index);
var_dump(count($res));
