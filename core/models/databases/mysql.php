<?php

class dbMySQL
{
    private mysqli $connection;

    private function connect()
    {
        $mysql_cfg = SERVERS['mysql'];
        $host = $mysql_cfg['host'];
        $port = (int) $mysql_cfg['port'];
        $userName = $mysql_cfg['userName'];
        $password = $mysql_cfg['password'];

        try {
            $this->connection = new mysqli(
                $host,
                $userName,
                $password,
                null,
                $port,
            );
        } catch (Exception $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_MYSQL_UNEXPECTED_CONNECTION_EXCEPTION', $ex);
        }
    }

    public function execute_SP(string $stored_procedure_name, array $params = [])
    {
        if (!isset($this->connection) || $this->connection === null) {
            $this->connect();
        }

        if ($params == []) {
            $str_params = '';
        } else {
            $str_params = '"' .  implode('","', $params) . '"';
        }

        $sp_query = 'CALL ' . $stored_procedure_name . '(' . $str_params . ')';

        try {
            $res = $this->connection->query($sp_query);
        } catch (Exception $ex) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_MYSQL_UNEXPECTED_SP_EXECUTION_EXCEPTION', $ex);
        }

        $result = [];

        if (is_bool($res)) {
            if ($res == false) {
                $this->flag_coreError_dbRedis('???', $ex);
                return false;
            } else {
                $result = true;
            }
        } else {
            if ($res->num_rows > 1) {
                while ($row = $res->fetch_row()) {
                    array_push($result, $row);
                }
            } else {
                $result = $res->fetch_assoc();
            }

            return $result;
        }
    }
}
