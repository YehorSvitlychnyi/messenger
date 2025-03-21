<?php

namespace app\controllers;

use app\core\Response;
use app\core\Route;

class AuthController
{
    public function sigin()
    {
        echo('hello');
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

            // Тут має бути логіка оновлення пароля в БД
            // Наприклад (умовно):
            // $userModel = new UserModel();
            // $userModel->updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));

            echo "Пароль успішно змінено!";
        } else {
            // Якщо GET-запит — показуємо сторінку з формою
            $response = new Response();
            $response->view('reset_password');
        }
    }

    public function forgot(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['your_login'] ?? '';
            $answer = $_POST['secret_answer'] ?? '';
            if (empty($login) || empty($answer)) {
                echo "Please fill in all fields.";
                return;
            }
            if ($answer !== 'Anton') {
                echo "Incorrect secret word.";
                return;
            }
            echo "Login:" . $login . "<br>";
            echo "Secret answer: " . $answer;
        } else {
            $response = new Response();
            $response->view('forgot');
        }
    }

}