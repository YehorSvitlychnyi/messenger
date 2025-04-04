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
     * @var AbstractModel
     */
    protected AbstractModel $model;
    /**
     * @var Response
     */
    protected Response $response;
    protected Request $request;
    protected Validation $validation;

    public function __construct()
    {
        $this->response   = new Response();
        $this->model      = new UserModel();
        $this->request    = new Request();
        $this->validation = new Validation();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function signin(): void
    {
        $this->authView('auth', 'login', 'signIn');
    }

    /**
     * login user by Session after validating and checking inputted data
     * @return void
     */
    public function login(): void
    {
        $login    = $this->request->login;
        $password = $this->request->password;
        $this->validate('login', 'signin');
        Session::setItem('login', $login);
        $this->response->redirect(Route::url('chat', 'init'));
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function forgot(): void
    {
        $this->authView('forgot', 'forgotpassword', 'forgot password');
    }

    /**
     *
     * @return void
     */
    public function forgotPassword(): void
    {
        $login         = $this->request->login;
        $secret_answer = $this->request->secret_answer;
        $this->validate('forgot', 'forgot');
        Session::setItem('login_change', $login);
        $this->response->redirect(Route::url('auth', 'reset'));
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function reset(): void
    {
        $this->authView('reset_password', 'resetpassword', 'reset password');
    }

    /**
     * @return void
     */
    public function resetPassword(): void
    {
        $login = Session::getItem('login_change');
        if ($login === null) {
            $this->response->redirect(Route::url('auth', 'signin'));
        }
        $password        = $this->request->password;
        $repeat_password = $this->request->repeat_password;
        $this->validate('reset', 'reset');
        $this->model->changePassword($login, $password);
        Session::deleteItem('login_change');
        $this->response->redirect(Route::url('auth', 'signin'));
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function signup(): void
    {
        $this->authView('register', 'register', 'register');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->validate('register', 'signup');
        $name            = $this->request->name;
        $login           = $this->request->login;
        $password        = $this->request->password;
        $repeat_password = $this->request->repeat_password;
        $secret_answer   = $this->request->secret_answer;
        $password        = password_hash($password, PASSWORD_DEFAULT);
        $secret_answer   = password_hash($secret_answer, PASSWORD_DEFAULT);
        $this->model->add([
            'name'          => $name,
            'login'         => $login,
            'password'      => $password,
            'secret_answer' => $secret_answer,
        ]);
        $this->response->redirect(Route::url('auth', 'signin'));
    }

    /**
     * @param string $page
     * @param string $action
     * @param string $title
     *
     * @return void
     * @throws \Exception
     */
    private function authView(string $page, string $action, string $title = 'messenger'): void
    {
        $this->response->view($page, [
            'title'  => $title,
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