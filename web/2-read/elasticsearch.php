<?php

require __DIR__ . '/../../vendor/autoload.php';

use Elasticsearch\Client;

$elasticsearch = new Client();
$res = array();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $params = array(
        'index' => 'test',
        'type' => 'test',
        'q' => 'id:'.$id
    );
    $resultat = $elasticsearch->search($params);
    if($resultat['hits']['total'] > 0){
       $res[] =  $resultat;
    }
}
var_dump(count($res));
