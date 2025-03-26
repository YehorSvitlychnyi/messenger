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

    protected Request $request;

    /**
     * @var AbstractModel
     */
    protected $model;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new UserModel();
        $this->request = new Request();
    }


    public function signin(): void
    {
        $this->authView('auth','login','signIn');
    }

    public function login()
    {
        $login = $this->request->login;
        $password = $this->request->password;
        //todo validate
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        } else if (!password_verify($password, $user['password'])) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['auth_error']);
            //todo errors from validate
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        Session::setItem('login', $login);
        $this->response->redirect(Route::url('Api', 'getchats'));
    }

    public function forgot()
    {
        $this->authView('forgot','forgotpassword','forgot password');
    }

    public function forgotpassword()
    {
        $login = $this->request->login;
        $answer = $this->request->answer;
        //TODO validate
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        } else if (!password_verify($answer, $user['secret_answer'])) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['forgot_password_error']);
            //todo errors from validate
            $this->response->redirect(Route::url('auth', 'forgot'));
        }
        Session::setItem('login_change', $login);
        $this->response->redirect(Route::url('auth', 'reset'));
    }

    public function reset()
    {
        $this->authView('reset_password','resetpassword','reset password');
    }

    public function resetpassword()
    {
        $login = Session::getItem('login_change');
        if ($login === null) {
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        $password = $this->request->password;
        $repeat_password = $this->request->repeat_password;
        //TODO validate and repeat_password
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['No_login_error']);
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        $this->model->changePassword($login,$password);
        Session::deleteItem('login_change');
        $this->response->redirect(Route::url('auth', 'signin'));
    }
    public function signup(){
        $this->authView('register','register','register');
    }
    public function register()
    {
        $name = $this->request->name;
        $login = $this->request->login;
        $password = $this->request->password;
        $repeat_password = $this->request->repeat_password;
        $secret_answer = $this->request->secret_answer;
        //todo validate
        $password = password_hash($password, PASSWORD_DEFAULT);
        $secret_answer = password_hash($secret_answer, PASSWORD_DEFAULT);
        $this->model->add([
            'name' => $name,
            'login' => $login,
            'password' => $password,
            'secret_answer' => $secret_answer,
        ]);
        $this->response->redirect(Route::url('auth', 'signin'));
    }
    private function authView(string $page, string $action, string $title = 'messenger'){
        $this->response->view($page, [
            'title' => $title,
            'action' => Route::url('auth', $action),
            'errors' => Session::getErrors(),
        ]);
    }
}