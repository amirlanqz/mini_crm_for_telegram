<?php

require_once __DIR__ . "/Database.php";
class Role
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        try {
            $this->db->query("SELECT 1 FROM roles limit 1");
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

        try {
            $this->db->exec($roleTableQuery);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function getAllRoles()
    {
        try {
            $query = $this->db->query("SELECT * FROM roles");
            return $query->fetchAll();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getRoleById($id): ?array
    {
        $stmt = $this->db->prepare("select * from roles where id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public function createRole($roleName, $roleDescription)
    {
        $query = "insert into roles (role_name, role_description) values (?,?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$roleName, $roleDescription]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateRole($id, $roleName, $roleDescription): bool
    {
        $query = "update roles set role_name = ?, role_description = ? where id = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([$roleName, $roleDescription, $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}