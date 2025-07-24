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
        $results =  $this->db->query("SELECT id, login, is_admin, created_at FROM users order by id asc");
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
        if ($stmt->execute([$login, $password, $isAdmin, $createdAt])) {
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
        $user = $stmt->fetch();
        return $user;
    }

    public function update($id, $data) {
        $login = $data['login'];
        $isAdmin = isset($data['is_admin']) ? (int)$data['is_admin'] : 0;
        $stmt = $this->db->prepare("UPDATE users SET login = ?, is_admin = ? WHERE id = ?");
        if ($stmt->execute([$login, $isAdmin, $id])) {
            return true;
        } else {
            return false;
        }

    }
}