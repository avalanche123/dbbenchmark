<?php

require __DIR__ . '/../../vendor/autoload.php';

use Elasticsearch\Client;

$client = new Client();
$params = array(
    'index' => 'test',
    'type' => 'test',
    'q' => '*'
);
$ret = $client->search($params);
var_dump($ret);