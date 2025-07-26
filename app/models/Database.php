<?php

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct(){

        $config = require_once __DIR__ . "/../../config.php";
        $db_host = $config['db_host'];
        $db_user = $config['db_user'];
        $db_password = $config['db_password'];
        $db_name = $config['db_name'];

        $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

        try {
            $this->conn = new \PDO($dsn, $db_user, $db_password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

}