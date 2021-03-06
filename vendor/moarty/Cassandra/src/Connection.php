<?php
namespace cassandra;

use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocolAccelerated;

use cassandra\CassandraClient;
use cassandra\AuthenticationRequest;
use cassandra\Compression;

/**
 * @internal
 */
class Connection {

    const LOWEST_COMPATIBLE_VERSION = 17;
    const DEFAULT_PORT = 9160;
    public $keyspace;
    public $client;
    public $op_count;

    public function __construct($keyspace,
                                $server,
                                $credentials=null,
                                $framed_transport=True,
                                $send_timeout=null,
                                $recv_timeout=null)
    {
        $this->server = $server;
        $server = explode(':', $server);
        $host = $server[0];
        if(count($server) == 2)
            $port = (int)$server[1];
        else
            $port = self::DEFAULT_PORT;
        $socket = new TSocket($host, $port);

        if($send_timeout) $socket->setSendTimeout($send_timeout);
        if($recv_timeout) $socket->setRecvTimeout($recv_timeout);

        if($framed_transport) {
            $transport = new TFramedTransport($socket, true, true);
        } else {
            $transport = new TBufferedTransport($socket, 1024, 1024);
        }

        $this->client = new CassandraClient(new TBinaryProtocolAccelerated($transport));
        $transport->open();

        $this->set_keyspace($keyspace);

        if ($credentials) {
            $request = new AuthenticationRequest(array("credentials" => $credentials));
            $this->client->login($request);
        }

        $this->keyspace = $keyspace;
        $this->transport = $transport;
        $this->op_count = 0;
    }
    
    public function execute_cql3_query($query)
    {
        return $this->client->execute_cql3_query($query, Compression::NONE, true);
    }
    public function prepare_cql3_query($query)
    {
        return $this->client->prepare_cql3_query($query, Compression::NONE);
    }
    
    public function execute_prepared_cql3_query($itemId, $values)
    {
        return $this->client->execute_prepared_cql3_query($itemId, $values, true);
    }
    public function prepare_cql_query($query)
    {
        return $this->client->prepare_cql_query($query, Compression::NONE);
    }
    public function execute_prepared_cql_query($itemId, $values)
    {
        return $this->client->execute_prepared_cql_query($itemId, $values);
    }
    
    public function batch_mutate($mutation_map)
    {
        return $this->client->batch_mutate($mutation_map, ConsistencyLevel::ONE);
    }
    
    public function close() {
        $this->transport->close();
    }

    public function set_keyspace($keyspace) {
        if ($keyspace !== NULL) {
            $this->client->set_keyspace($keyspace);
            $this->keyspace = $keyspace;
        }
    }

}
