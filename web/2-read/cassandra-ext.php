<?php

require __DIR__ . '/../../vendor/autoload.php';

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect('ext');
$statement = new Cassandra\SimpleStatement("SELECT * FROM user WHERE id = ?");
$options   = new Cassandra\ExecutionOptions();
$futures   = array();

for ($index = 0; $index < 100; $index++) {
    $options->arguments = array(rand(0, 1000000));
    $futures[]= $session->executeAsync($statement, $options);
}

$res = array();
foreach ($futures as $future) {
    /** @var \Cassandra\Rows $result */
    $result    = $future->get();
    if($result->count()){
        $res[] =  $result->current();
    }
}
var_dump(count($res));
