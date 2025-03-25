<?php


namespace app\controllers;


use app\core\Response;
use app\core\AbstractModel;
use app\core\Route;
use app\core\Session;

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
    }
    public function signin()
    {
        $this->response->view('auth', [
            'content' => 'Hi',
            'action' => Route::url('auth', 'login'),
//            'errors' => Session::getErrors(),
        ]);
    }

//    public function login($request)
//    {
//        $login = $request->login;
//        $password = $request->password;
//        //TODO validate
//        $user = $this->model->getByLogin($login);
//        $validUserCred = true;
//        if (!$user) {
//            $validUserCred = false;
//        }else if (!password_verify($password, $user['password'])) {
//            $validUserCred = false;
//        }
//        if (!$validUserCred) {
//            Session::setErrors([Translate::getText('auth_error')]);
//            $this->response->redirect(Route::url('auth'));
//        }
//        Auth::setUser(['login' => $login]);
//        $this->response->redirect(Route::url('task'));
//    }




}