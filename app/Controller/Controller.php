<?php

namespace App\Controller;

class Controller
{
    static function loginAction(array $data)
    {
        if ($data['login'] == ''){
            Log::message('Login em branco.');
            self::homeAction();
        }

        if ($data['password'] == ''){
            Log::message('Senha em branco');
            self::homeAction();
        }

        // Efetuar as rotinas de login


        // Login OK, carregar a view principal
        $_SESSION['userId'] = 1;
        $_SESSION['userName'] = $data['login'];

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
     * Passa o controle para a página da rede passando a view a ser carregada lá
     */
    static function viewAction($view)
    {
        // Monta a localização da página principal com a view a ser carregada
        $location = 'socialnet.php?view=' . $view;
        // Redireciona para a página principal com a página a ser carregada por lá
        header('Location: ' . $location);
    }
}