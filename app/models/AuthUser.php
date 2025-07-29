<?php

require_once __DIR__ . "/Database.php";
class AuthUser
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        try {
            $result = $this->db->query("SELECT 1 FROM users limit 1");
        } catch (PDOException $e) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $roleTableQuery = "CREATE TABLE IF NOT EXISTS roles (
        id int(11) not null auto_increment primary key,
        role_name varchar(255) not null,
        role_description text
    )";

        $userTableQuery = "CREATE TABLE IF NOT EXISTS users (
        id int(11) not null auto_increment,
        username varchar(255) not null,
        email varchar(255) not null unique,
        email_verification tinyint(1) not null default 0,
        password varchar(255) not null,
        is_admin tinyint(1) not null default 0,
        role_id int(11) not null,
        is_active tinyint(1) not null default 1,
        last_login timestamp null,
        created_at timestamp default current_timestamp,
        primary key (id),
        foreign key (role_id) references roles(id) 
    )";

        try {
            $this->db->exec($roleTableQuery);
            $this->db->exec($userTableQuery);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    public function register($data)
    {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO users (username, email, password, role_id, created_at) values (?,?,?,?,?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$data['username'], $data['email'], $data['password'], 1, $created_at]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password)
    {
        try {
            $user = $this->findByEmail($email);

            if (password_verify($password, $user['password'])) {
                return $user;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // Вернёт массив с данными пользователя
    }
}