<?php

require __DIR__ . '/vendor/autoload.php';


/*
 * TEST SELECT CASSANDRA
 */
//use cassandra\Connection;
//
//$con = new Connection('mykeyspace', '127.0.0.1');
//$res = $con->prepare_cql3_query("SELECT * FROM users WHERE fname = ?");
//$res = $con->execute_prepared_cql3_query($res->itemId, array('toto'));
//
//var_dump($res);

/*
 * TEST SELECT MYSQL
 */
//$con = @mysqli_connect("localhost","root",null,"test");
//
//$res = mysqli_query($con,"SELECT * FROM test");
//
//while($row = mysqli_fetch_array($res)) {
//  var_dump($row);
//}
//mysqli_close($con);

/*
 * TEST SELECT PDO
 */
//$PARAM_hote='localhost'; // le chemin vers le serveur
//$PARAM_port='3306';
//$PARAM_nom_bd='test'; // le nom de votre base de données
//$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
//$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
//$connexion = new PDO('mysql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
//
//$resultats=$connexion->query("SELECT * FROM test"); 
//$resultats->setFetchMode(PDO::FETCH_OBJ); 
//while( $ligne = $resultats->fetch() ) 
//{
//    var_dump($ligne);
//}
//$resultats->closeCursor(); // on ferme le curseur des résultats

/*
 * TEST SELECT ELASTICSEARCH
 */
use Elasticsearch\Client;

$client = new Client();
$params = array(
    'index' => 'test',
    'type' => 'test',
    'q' => '*'
);
$ret = $client->search($params);
var_dump($ret);

/*
 * TEST INSERT ELASTICSEARCH
 */
//$params = array(
//    'body' => array('id' => 134, 'fname' => 'toto', 'lname' => 'morard'),
//    'index' => 'test',
//    'type' => 'test',
//);
//$ret = $client->index($params);



//$toto = array('toto', 'tata', 'tutu');
//echo json_encode($toto);