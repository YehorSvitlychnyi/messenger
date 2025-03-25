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




}