<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');

$statement = new Cassandra\SimpleStatement("SELECT * FROM user limit 5000");
/** @var \Cassandra\Rows $result */
$result    = $session->execute($statement);


var_dump($result->count());
