<?php

require __DIR__ . '/../../vendor/autoload.php';

use Elasticsearch\Client;

$elasticsearch = new Client();

for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $params = array(
        'body' => array('id' => $id, 'fname' => $fname, 'lname' => $fname, 'description' => $description),
        'index' => 'test',
        'type' => 'test',
    );
    $elasticsearch->index($params);
}

var_dump($index);