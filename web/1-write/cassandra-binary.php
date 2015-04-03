<?php

require __DIR__ . '/../../vendor/autoload.php';

$nodes = ['127.0.0.1'];

// Connect to database.
$database = new evseevnn\Cassandra\Database($nodes, 'binary');
$database->connect();

for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $database->query("INSERT INTO user (id, fname, lname, description) VALUES (:id, :fname, :lname, :description)", [$id, $fname, $lname, $description]);
}

var_dump($index);
