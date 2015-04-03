<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');

$statement = new Cassandra\SimpleStatement("SELECT * FROM user limit 5000");
$future    = $session->executeAsync($statement);
/** @var \Cassandra\Rows $result */
$result    = $future->get();


var_dump($result->count());