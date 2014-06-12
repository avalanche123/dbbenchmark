<?php

require __DIR__ . '/../../vendor/autoload.php';

$connexion = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");

for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $connexion->query("INSERT INTO user (id, fname, lname, description) VALUES ($id, '".$fname."', '".$lname."', '".$description."')");
    
    $id = rand(0, 1000000);
    
    $resultats = $connexion->query("SELECT * FROM user WHERE id = $id"); 
    $resultats->setFetchMode(PDO::FETCH_UNIQUE);
    $resultat = $resultats->fetch();
    if($resultat){
        $res[] = $resultat;
    }
}

var_dump($index);
var_dump(count($res));