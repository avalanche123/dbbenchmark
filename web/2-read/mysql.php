<?php

require __DIR__ . '/../../vendor/autoload.php';

$connexion = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");

$res = array();
for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    
    $resultats = $connexion->query("SELECT * FROM user WHERE id = $id"); 
    $resultats->setFetchMode(PDO::FETCH_UNIQUE);
    $resultat = $resultats->fetch();
    if($resultat){
        $res[] = $resultat;
    }
}
var_dump(count($res));