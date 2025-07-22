<?php


require_once __DIR__ . '/Database.php';
class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function readAll() {
        $results =  $this->db->query("SELECT * FROM users");
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
        $login = $data['login'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $isAdmin = isset($data['is_admin']) && $data['is_admin'] === 1 ? 1 : 0;
        $createdAt = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("INSERT INTO users (login, password, is_admin, created_at) VALUES (?,?,?,?)");
        $success = $stmt->execute([$login, $password, $isAdmin, $createdAt]);
        if ($success) {
            return true;
        } else {
            return false;
        }

    }
}