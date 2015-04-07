<?php

require __DIR__ . '/../vendor/autoload.php';

use cassandra\Connection;
use Elasticsearch\Client;

$cluster = Cassandra::cluster()->build();
$session   = $cluster->connect();

/*
 * DROP KEYSPACE, DATABASE AND INDEX
 */
$statement = new Cassandra\SimpleStatement("DROP KEYSPACE IF EXISTS thrift");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("DROP KEYSPACE IF EXISTS binary");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("DROP KEYSPACE IF EXISTS ext");
$session->execute($statement);

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
 * CREATE CASSANDRA KEYSPACES AND TABLES
 */
$cluster = Cassandra::cluster()->build();
$statement = new Cassandra\SimpleStatement("CREATE KEYSPACE IF NOT EXISTS thrift WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("CREATE TABLE IF NOT EXISTS thrift.user (id int PRIMARY KEY, fname text, lname text, description text)");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("CREATE INDEX IF NOT EXISTS ON thrift.user (fname)");
$session->execute($statement);
echo "Cassandra with Thrift is ready\n";


$statement = new Cassandra\SimpleStatement("CREATE KEYSPACE IF NOT EXISTS ext WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("CREATE TABLE IF NOT EXISTS ext.user (id int PRIMARY KEY, fname text, lname text, description text)");
$session->execute($statement);
$statement = new Cassandra\SimpleStatement("CREATE INDEX IF NOT EXISTS ON ext.user (fname)");
$session->execute($statement);
echo "Cassandra with Extension is ready\n";



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
echo "Cassandra with binary protocol is ready\n";


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