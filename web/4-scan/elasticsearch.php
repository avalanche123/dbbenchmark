<?php

require __DIR__ . '/../../vendor/autoload.php';

use Elasticsearch\Client;

$elasticsearch = new Client();
$params = array(
    'index' => 'test',
    'type' => 'test',
    'q' => '*',
    'size' => 5000
);
$resultat = $elasticsearch->search($params);
var_dump(count($resultat['hits']['hits']));