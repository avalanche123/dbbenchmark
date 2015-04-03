<?php

require __DIR__ . '/../../vendor/autoload.php';

$nodes = ['127.0.0.1'];

// Connect to database.
$database = new evseevnn\Cassandra\Database($nodes, 'binary');
$database->connect();

$resultat = $database->query("SELECT * FROM user limit 5000");

var_dump(count($resultat));
