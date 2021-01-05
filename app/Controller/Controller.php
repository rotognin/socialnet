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

        $_SESSION['userId'] = $o_user->usuId;
        $_SESSION['userName'] = $o_user->usuName;

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
        if (!Filters::commomText($data['name'])){
            Log::message('Caracteres inválidos no nome');
            header('Location: createuser.php');
            exit();
        }
        
        if ($data['name'] == '' || $data['login'] == ''){
            Log::message('Existem campos em branco');
            header('Location: createuser.php');
            exit();
        }

        


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