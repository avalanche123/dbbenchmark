<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');

// BEGIN WRITES
$futures = array();
$statement = new Cassandra\SimpleStatement("INSERT INTO user (id, fname, lname, description) VALUES (?, ?, ?, ?)");
$options = new Cassandra\ExecutionOptions();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $options->arguments = array($id, $fname, $lname, $description);
    $futures[]= $session->executeAsync($statement, $options);
}

// make sure all writes complete
foreach ($futures as $future) {
    $future->get();
}
var_dump($index);
// END WRITES

// BEGIN READS
$futures = array();
$statement = new Cassandra\SimpleStatement("SELECT * FROM user WHERE id = ?");
for ($index = 0; $index < 100; $index++) {
    $options->arguments = array(rand(0, 1000000));
    $futures[]= $session->executeAsync($statement, $options);
}

$res = array();
foreach ($futures as $future) {
    /** @var \Cassandra\Rows $result */
    $result = $future->get();
    if($result->count()){
        $res[] =  $result->current();
    }
}

var_dump(count($res));
// END READS
