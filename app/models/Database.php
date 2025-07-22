<?php

class Database
{
    private static $instance = null;
    private $conn;
    private $host = "mysql";
    private $user = "user";
    private $pass = 'secret';
    private $name = 'app';


    private function __construct(){
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8mb4";

        try {
            $this->conn = new \PDO($dsn, $this->user, $this->pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

}