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
    public function signin()
    {
        $response = new \app\core\Response();
        $response->view('auth');
    }


    public function resetPassword(): void
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
    public function forgot()
    {
        $this->response->view('forgot', [
            'title' => 'forgot password',
            'action' => Route::url('auth', 'forgotpassword'),
            'errors' => Session::getErrors(),
        ]);
    }
    public function forgotpassword(){
        $request = new Request();
        $login = $request->login;
        $answer = $request->answer;
        //TODO validate
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        }else if (!password_verify($answer, $user['secret_answer'])) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['forgot_password_error']);
            //todo errors from validate
            $this->response->redirect(Route::url('auth', 'forgot'));
        }
        Session::setItem('login_change', $login);
        $this->response->redirect(Route::url('auth','reset'));
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