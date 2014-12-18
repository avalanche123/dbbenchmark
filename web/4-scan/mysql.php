<?php

require __DIR__ . '/../../vendor/autoload.php';

$connexion = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");
    
$resultats = $connexion->query("SELECT * FROM user LIMIT 5000");
$resultats->setFetchMode(PDO::FETCH_ASSOC);
$resultat = $resultats->fetchAll();
var_dump(count($resultat));