<?php

namespace app\Controller;

use app\Model as Model;

class Controller
{
    /**
     * Realizar o login do usuário
     */
    static function loginAction(array $data)
    {
        if ($data['login'] == '' || $data['password'] == ''){
            Log::message('Login ou Senha em branco.');
            self::homeAction();
        }

        $o_user = new Model\User();
        if (!$o_user->login($data['login'], $data['password'])){
            self::homeAction();
        }

        $_SESSION['userId'] = $o_user->user['usuId'];
        $_SESSION['userName'] = $o_user->user['usuName'];

        self::mainAction();
    }

    static function logoutAction()
    {
        session_unset();
        self::homeAction();
    }

    static function homeAction()
    {
        header('Location: ' . DIR['home']);
        exit();
    }

    /**
     * Chama a página principal do usuário logado
     */
    static function mainAction()
    {
        self::viewAction('index');
    }

    /**
     * Verificação de criação de novo usuário
     */
    static function newuserAction(array $data)
    {
        UserController::newUser($data);
    }

    /**
     * Criar nova postagem
     */
    static function insertuserpostAction(array $data)
    {
        Log::write('Chegou até aqui para gravar a postagem');
        Log::write(print_r($data, true));
        PostController::insert($data); // *** a ser desenvolvida
    }

    /**
     * Atualizar postagem
     */
    static function updateuserpostAction(array $data)
    {
        PostController::update($data); // *** a ser desenvolvida
    }

    /**
     * Perfil do usuário logado
     */
    static function profileAction()
    {
        self::viewAction('profile');
    }

    /**
     * Criar uma postagem
     */
    static function createuserpostAction()
    {
        self::viewAction('post');
    }

    /**
     * Atualização do usuário
     */
    static function updateuserAction($data)
    {
        UserController::updateUser($data);
        self::mainAction();
    }

    /**
     * Passa o controle para a View
     */
    static function viewAction($view)
    {
        // Monta a localização da página principal com a view a ser carregada
        $location = 'socialnet.php?view=' . $view;
        // Redireciona para a página principal com a página a ser carregada por lá
        header('Location: ' . $location);
    }
}