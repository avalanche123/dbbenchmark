<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');

$res = array();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $statement = new Cassandra\SimpleStatement("INSERT INTO user (id, fname, lname, description) VALUES ($id, '".$fname."', '".$lname."', '".$description."')");
    $session->executeAsync($statement);

    $id = rand(0, 1000000);
    $statement = new Cassandra\SimpleStatement("SELECT * FROM user WHERE id = $id");
    $future    = $session->executeAsync($statement);
    /** @var \Cassandra\Rows $result */
    $result    = $future->get();
    if($result->count()){
        $res[] =  $result->current();
    }
}

var_dump($index);
var_dump(count($res));
