<?php

namespace app\controllers;

use app\core\Response;
use app\core\Route;

class AuthController
{
    public function signin()
    {
        $response = new \app\core\Response();
        $response->view('auth');
    }


    public function resetPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'] ?? '';
            $repeatPassword = $_POST['repeat_password'] ?? '';

            if ($newPassword !== $repeatPassword) {
                echo "Паролі не співпадають!";
                return;
            }

            // Логіка зміни пароля (наприклад, через UserModel)

            header("Location: " . \app\core\Route::url('auth', 'signin'));
            exit();
        } else {
            $response = new \app\core\Response();
            $response->view('reset_password');
        }
    }




}
