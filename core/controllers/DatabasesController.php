<?php

// Databases
require_once 'core/models/databases/redis.php';
require_once 'core/models/databases/mysql.php';
require_once 'core/models/databases/mongodb.php';

class databasesController
{
    private static dbMySQL $dbMySQL;
    private static dbMongo $dbMongo;
    private static dbRedis $dbRedis;

    public static function mongoDB()
    {
        if (!isset(self::$dbMongo)) {
            self::$dbMongo = new dbMongo();
        }

        $dbMongo = &self::$dbMongo;
        return $dbMongo;
    }

    public static function mysqlDB()
    {
        if (!isset(self::$dbMySQL)) {
            self::$dbMySQL = new dbMySQL();
        }

        $dbMySQL = &self::$dbMySQL;
        return $dbMySQL;
    }

    public static function RedisDB()
    {
        if (!isset(self::$dbRedis)) {
            self::$dbRedis = new dbRedis();
        }

        $dbRedis = &self::$dbRedis;
        return $dbRedis;
    }
}