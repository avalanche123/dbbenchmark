<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');

$futures = array();
$statement = $session->prepare("INSERT INTO user (id, fname, lname, description) VALUES (?, ?, ?, ?)");
$options = new Cassandra\ExecutionOptions();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $options->arguments = array($id, $fname, $lname, $description);
    $futures[]= $session->executeAsync($statement, $options);
}

foreach ($futures as $future) {
    // wait for the INSERT to complete
    $future->get();
}

var_dump($index);
