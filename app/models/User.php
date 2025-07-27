<?php


require_once __DIR__ . '/Database.php';
class User
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



    public function readAll() {
        $results =  $this->db->query("SELECT u.*, r.role_name FROM users u join roles r on u.role_id = r.id");
        $users = [];
//        while($row = $result->fetch()){
//            $users[] = $row;
//        }
        foreach ($results as $result) {
            $users[] = $result;
        }
        return $users;
    }

    public function create($data): bool
    {
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $email = $data['email'];
        $roleId = $data['role_id'];
        $createdAt = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role_id, created_at) VALUES (?,?,?,?,?)");
        if ($stmt->execute([$username, $email, $password, $roleId, $createdAt])) {
            return true;
        } else {
            return false;
        }

    }


    public function delete($id): bool
    {
        $deleted = $this->db->prepare("DELETE FROM users WHERE id = ?");
        if ($deleted->execute([$id])) {
            return true;
        } else {
            return false;
        }
    }

    public function read($id)
    {
        $stmt =  $this->db->prepare("SELECT * FROM users where id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function update($id, $data) {
        $username = $data['username'];
        $email = $data['email'];
        $role_id = $data['role_id'];
        $stmt = $this->db->prepare("UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?");
        if ($stmt->execute([$username, $email, $role_id, $id])) {
            return true;
        } else {
            return false;
        }

    }
}