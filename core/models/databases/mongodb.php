<?php

use MongoDB\Operation\InsertOne;

class dbMongo
{
    private MongoDB\Client $connection;

    public function __construct()
    {
        $mongo_cfg = SERVERS['mongodb'];
        $host = $mongo_cfg['host'];
        $port = (int) $mongo_cfg['port'];
        // $userName = $mysql_cfg['userName'];
        // $password = $mysql_cfg['password'];

        try {
            $this->connection = new MongoDB\Client("mongodb://" . $host . ':' . $port);
        } catch (Exception $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_MONGODB_UNEXPECTED_CONNECTION_EXCEPTION', $ex);
        }
    }

    public function single_insert(string $db_name, string $document, array $content)
    {
        try {
            $db = $this->connection->{$db_name};
            $doc = $db->{$document};
            $doc->InsertOne($content);
        } catch (Exception $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_MONGODB_UNEXPECTED_SINGLE_INSERT', $ex);
        }
    }
}
