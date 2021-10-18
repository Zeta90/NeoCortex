<?php


class dbRedis
{
    private Redis $connection;

    public function connect()
    {
        $redis_cfg = SERVERS['redis'];
        $host = $redis_cfg['host'];
        $port = (int) $redis_cfg['port'];
        // $userName = $redis_cfg['userName'];
        // $password = $redis_cfg['password'];

        try {
            $this->connection = new Redis();
            $this->connection->connect($host, $port);

            if (!$this->connection->ping()) {
                // ERROR REDIS PING
                coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_GET_PARAMS_FAILED');
            }
        } catch (Throwable $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REDIS_UNEXPECTED_EXCEPTION', $ex);
        }
    }

    private function select_database(string $database)
    {
        $database_list = SERVERS['redis']['databases'];
        $selected_db_id = $database_list[$database];

        try {
            $this->connection->select($selected_db_id);
        } catch (Throwable $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REDIS_SELECTED_DATABASE_FAILED', $ex);
        }
    }

    public function _set(string $key, string $value, $database)
    {
        if (!isset($this->connection)) {
            $this->connect();
        }

        $this->select_database($database);

        try {
            $this->connection->set($key, $value);
        } catch (Throwable $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REDIS_SET_PAIR_FAILED', $ex);
        }
    }

    public function _get(string $key, $database = null)
    {
        if (!isset($this->connection)) {
            $this->connect();
        }

        $this->select_database($database);

        try {
            $result = $this->connection->get($key);
            return $result;
        } catch (Throwable $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REDIS_GET_VALUE_FAILED', $ex);
        }
    }

    public function _keys(string $key, $database = null)
    {
        if (!isset($this->connection)) {
            $this->connect();
        }

        $this->select_database($database);

        try {
            $result = $this->connection->keys($key);
            $this->result = $result;
        } catch (Throwable $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REDIS_GET_KEYS_FAILED', $ex);
        }
    }
}
