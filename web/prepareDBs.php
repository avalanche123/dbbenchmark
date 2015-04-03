<?php

require __DIR__ . '/../vendor/autoload.php';

use cassandra\Connection;
use Elasticsearch\Client;


/*
 * DROP KEYSPACE, DATABASE AND INDEX
 */
$cassandra = new Connection('system', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("DROP KEYSPACE IF EXISTS thrift");
$resCassandra = $cassandra->execute_cql3_query("DROP KEYSPACE IF EXISTS binary");
$resCassandra = $cassandra->execute_cql3_query("DROP KEYSPACE IF EXISTS ext");

$elasticsearch = new Client();
if($elasticsearch->indices()->exists(array('index' => 'test'))){
    $resElastic = $elasticsearch->indices()->delete(array('index' => 'test'));
}

try{
    $mysql = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', "");
    $resMysql = $mysql->query("DROP DATABASE test IF EXISTS");
}catch(\PDOException $e){

}


/*
 * CREATE CASSANDRA KEYSPACE AND TABLE
 */
$cassandra = new Connection('system', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE KEYSPACE IF NOT EXISTS thrift WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$cassandra->close();

$cassandra = new Connection('thrift', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE TABLE IF NOT EXISTS user (id int PRIMARY KEY, fname text, lname text, description text)");

$res = $cassandra->execute_cql3_query("CREATE INDEX IF NOT EXISTS ON user (fname)");
$cassandra->close();

if($resCassandra){
    echo "Cassandra with Thrift is ready\n";
}


$cassandra = new Connection('system', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE KEYSPACE IF NOT EXISTS ext WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$cassandra->close();

$cassandra = new Connection('ext', '127.0.0.1');
$resCassandra = $cassandra->execute_cql3_query("CREATE TABLE IF NOT EXISTS user (id int PRIMARY KEY, fname text, lname text, description text)");

$res = $cassandra->execute_cql3_query("CREATE INDEX IF NOT EXISTS ON user (fname)");
$cassandra->close();

if($resCassandra){
    echo "Cassandra with Extension is ready\n";
}


/*
 * CREATE CASSANDRA KEYSPACE AND TABLE WITH BINARY PROTOCOL
 */
$nodes = ['127.0.0.1'];

// Connect to database.
$database = new evseevnn\Cassandra\Database($nodes, 'system');
$database->connect();
$database->query("CREATE KEYSPACE IF NOT EXISTS binary WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$database->setKeyspace('binary');
$database->query("CREATE TABLE IF NOT EXISTS user (id int PRIMARY KEY, fname text, lname text, description text)");
$res = $database->query("CREATE INDEX IF NOT EXISTS ON user (fname)");
$database->disconnect();
if($resCassandra){
    echo "Cassandra with binary protocol is ready\n";
}


/*
 * CREATE ELASTICSEARCH INDEX AND TYPE AND SET MAPPING
 */
$elasticsearch = new Client();
$indexParams['index']  = 'test';
if(!$elasticsearch->indices()->exists(array('index' => 'test'))){
    $elasticsearch->indices()->create($indexParams);
}


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