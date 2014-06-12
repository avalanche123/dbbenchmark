<?php

require __DIR__ . '/../../vendor/autoload.php';

$PARAM_hote='localhost'; // le chemin vers le serveur
$PARAM_port='3306';
$PARAM_nom_bd='test'; // le nom de votre base de données
$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);

$resultats=$connexion->query("SELECT * FROM test"); 
$resultats->setFetchMode(PDO::FETCH_OBJ); 
while( $ligne = $resultats->fetch() ) 
{
    var_dump($ligne);
}
$resultats->closeCursor(); // on ferme le curseur des résultats