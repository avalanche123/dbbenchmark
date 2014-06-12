<?php

require __DIR__ . '/../../vendor/autoload.php';

$connexion = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");


for ($index = 0; $index < 100; $index++) {
    $id = rand(0, 1000000);
    $fname = md5($id);
    $lname = sha1($id);
    $description = $fname . $lname;
    $connexion->query("INSERT INTO user (id, fname, lname, description) VALUES ($id, '".$fname."', '".$lname."', '".$description."')");
}

var_dump($index);