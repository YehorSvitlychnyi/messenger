<?php


namespace app\controllers;


use app\core\Request;
use app\core\Response;
use app\core\AbstractModel;
use app\core\Route;
use app\core\Session;
use app\models\UserModel;
use app\core\Validation;


class AuthController
{
    /**
     * @var Response
     */
    protected Response $response;

    protected Request $request;
    protected Validation $validation;

    /**
     * @var AbstractModel
     */
    protected $model;

    public function __construct()
    {
        $this->response = new Response();
        $this->model = new UserModel();
        $this->request = new Request();
        $this->validation = new Validation();
    }


    public function signin(): void
    {
        $this->authView('auth','login','signIn');
    }

    public function login(): void
    {
        $this->validate('login', 'signin');
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
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        Session::setItem('login', $login);
        $this->response->redirect(Route::url('chat', 'init'));
    }

    public function forgot()
    {
        $this->authView('forgot','forgotpassword','forgot password');
    }

    public function forgotpassword()
    {
        $this->validate('forgot', 'forgot');
        $login = $this->request->login;
        $secret_answer = $this->request->secret_answer;
        $user = $this->model->getByLogin($login);
        $userValidation = true;
        if (!$user) {
            $userValidation = false;
        } else if (!password_verify($secret_answer, $user['secret_answer'])) {
            $userValidation = false;
        }
        if (!$userValidation) {
            Session::setErrors(['forgot_password_error']);
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
        $this->validate('reset', 'reset');
        $password = $this->request->password;
        $repeat_password = $this->request->repeat_password;
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
        if ($this->model->getByLogin($this->request->login)) {
            Session::setErrors(['login' => ['Цей логін вже зайнятий']]);
            $this->response->redirect(Route::url('auth', 'signup'));
        }
        $this->validate('register', 'signup');
        $name = $this->request->name;
        $login = $this->request->login;
        $password = $this->request->password;
        $repeat_password = $this->request->repeat_password;
        $secret_answer = $this->request->secret_answer;
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

    /**
     * @param $method
     * @param $action
     *
     * @return void
     */
    private function validate($method, $action): void
    {
        if (!$this->validation->validate($method, $_POST)) {
            Session::setErrors($this->validation->getErrors());
            $this->response->redirect(Route::url('auth', $action));
        }
    }
}