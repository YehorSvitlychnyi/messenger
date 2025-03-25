<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\core\AbstractModel;
use app\core\Route;
use app\core\Session;
use app\models\UserModel;


class AuthController
{
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var AbstractModel
     */
    protected $model;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new UserModel();
    }
    public function signin()
    {
        $this->response->view('auth', [
            'title' => 'signIn',
            'action' => Route::url('auth', 'login'),
            'errors' => Session::getErrors(),
        ]);
    }

    public function login()
    {
        $request = new Request();
        $login = $request->login;
        $password = $request->password;
        //todo validate
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        }else if (!password_verify($password, $user['password'])) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['auth_error']);
            //todo errors from validate
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        Session::setItem('login', $login);
        $this->response->redirect(Route::url('Api','getchats'));
    }



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