<?php


class UserController
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
        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['is_admin']) ) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if ($password !== $confirm_password) {
                echo 'Password did not match';
                return;
            }
            $userModel = new User();
            $userModel->create($_POST);
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