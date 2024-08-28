<?php

namespace Core;

use PDO;

class Database
{
    private $config;

    public function __construct()
    {
        $this->config = Config::getInstance();
    }

    public function connect()
    {
        $dbConfig = $this->config->get('database');

        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        try {
            return new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $e) {
            throw new \Exception('Failed to connect to the database: ' . $e->getMessage());
        }
    }
}
