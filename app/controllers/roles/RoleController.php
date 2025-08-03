<?php

require_once __DIR__ . "/../../models/Role.php";


class RoleController
{

    public function index(){
        $userModel = new User();
        $users = $userModel->readAll();

        include __DIR__ . '/../../views/users/index.php';
    }

    public function create()
    {
        include __DIR__ . '/../../views/users/create.php';
    }

    public function store(): void
    {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email']) ) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if ($password !== $confirm_password) {
                echo 'Password did not match';
                return;
            }
            $userModel = new User();
            $data = [
                'username' => $_POST['username'],
                'email' =>$_POST['email'],
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id' => 1,
            ];
            $userModel->create($data);
        }
        header("Location: ?page=users");
    }


    public function edit()
    {
        $userModel = new User();
        $user = $userModel->read($_GET['id']);
        include __DIR__ . '/../../views/users/edit.php';
    }

    public function update()
    {
        $userModel = new User();
        $userModel->update($_GET['id'], $_POST);
        header("Location: ?page=users");
    }
    public function delete()
    {
        $userModel = new User();
        $userModel->delete($_GET['id']);

        if ($userModel) {
            header("Location: ?page=users");
        }
    }
}