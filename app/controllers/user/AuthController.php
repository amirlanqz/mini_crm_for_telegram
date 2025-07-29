<?php

require_once __DIR__ . '/../../models/AuthUser.php';
class AuthController
{
    public function register()
    {
        include __DIR__ . '/../../views/users/register.php';
    }

    public function store(): void
    {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email'])) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            if ($password !== $confirm_password) {
                echo 'Password did not match';
                return;
            }
            $userModel = new User();
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role_id' => 1,
            ];
            $userModel->create($data);
        }
        header("Location: ?page=login");
    }


    public function login()
    {
        include __DIR__ . '/../../views/users/login.php';
    }

    public function authenticate()
    {
        $authModel = new AuthUser();

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $authModel->findByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_role'] = $user->role_id;
                header("Location: ?page=home");
            } else {
                echo 'Invalid email or password';
            }
        } else {
            header("Location: ?page=login");
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?page=users");
    }
}