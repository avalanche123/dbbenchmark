<?php

require __DIR__ . '/../vendor/autoload.php';

use cassandra\Connection;
use Elasticsearch\Client;


/*
 * DROP KEYSPACE, DATABASE AND INDEX
 */
if(isset($_GET['drop'])){

    $cassandra = new Connection('system', '127.0.0.1');
    $resCassandra = $cassandra->execute_cql3_query("DROP KEYSPACE test");
    $resCassandra = $cassandra->execute_cql3_query("DROP KEYSPACE testbinary");

    $elasticsearch = new Client();
    $resElastic = $elasticsearch->indices()->delete(array('index' => 'test'));

    $mysql = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");
    $resMysql = $mysql->query("DROP DATABASE test"); 
    
    echo "Drop !\n";
    die();
}

/*
 * CREATE CASSANDRA KEYSPACE AND TABLE
 */
$cassandra = new Connection('system', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE KEYSPACE test WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$cassandra->close();

$cassandra = new Connection('test', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE TABLE user (id int PRIMARY KEY, fname text, lname text, description text)");

$res = $cassandra->execute_cql3_query("CREATE INDEX ON user (fname)");
$cassandra->close();

if($resCassandra){
    echo "Cassandra is ready\n";
}


/*
 * CREATE CASSANDRA KEYSPACE AND TABLE WITH BINARY PROTOCOL
 */
$nodes = ['127.0.0.1'];

// Connect to database.
$database = new evseevnn\Cassandra\Database($nodes, 'system');
$database->connect();
$database->query("CREATE KEYSPACE testbinary WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$database->setKeyspace('testbinary');
$database->query("CREATE TABLE user (id int PRIMARY KEY, fname text, lname text, description text)");
$res = $database->query("CREATE INDEX ON user (fname)");
$database->disconnect();
if($resCassandra){
    echo "Cassandra with binary protocol is ready\n";
}


/*
 * CREATE ELASTICSEARCH INDEX AND TYPE AND SET MAPPING
 */
$elasticsearch = new Client();
$indexParams['index']  = 'test';
$indexParams['body']  = array(
    'settings' => array(
        'index' => array(
            'analysis' => array(
                'analyzer' => array(
                    'my_french' => array(
                        'type' => 'french'
                    )
                )
            )
        ),
    )
);
$elasticsearch->indices()->create($indexParams);

$indexParams = array(
    'index' => 'test',
    'type' => 'user',
);
$indexParams['body']  = array(
    '_source' => array(
        'enabled' => true
    ),                
    'properties' => array(
        "id" => array(
            'type' => 'integer'
        ),
        'fname' => array(
            'type' => 'string',
            'index' => 'not_analyzed',
        ),
        'lname' => array(
            'type' => 'string',
            'index' => 'not_analyzed',
        ),
        'description' => array(
            'type' => 'string'
        )
    )
);
$resElastic = $elasticsearch->indices()->putMapping($indexParams);
if($resElastic){
    echo "Elasticsearch is ready\n";
}


/*
 * CREATE MYSQL DATABASE AND TABLE
 */
$mysql = new PDO('mysql:host=localhost;port=3306', 'root', "");
$mysql->query("CREATE DATABASE test");
$resMysql = $mysql->query("CREATE TABLE `test`.`user` (
    `id` INT NOT NULL,
    `fname` VARCHAR(45) NULL,
    `lname` VARCHAR(45) NULL,
    `description` TEXT NULL,
    PRIMARY KEY (`id`));");
if($resMysql){
    echo "Mysql is ready\n";
}