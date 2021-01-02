<?php

class Controller extends Log
{
    static function loginAction(array $data)
    {
        if ($data['login'] == ''){
            $_SESSION['message'] = 'Login em branco.';
            self::indexAction();
        }

        // Efetuar as rotinas de login


        // Login OK, carregar a view principal
        $_SESSION['userId'] = '1';
        $_SESSION['userName'] = 'Rodrigo Tognin';

        self::viewAction();
    }

    static function indexAction()
    {
        header('Location: ' . DIR['login']);
    }

    static function viewAction($page = '')
    {
        $view = ($page == '') ? DIR['baseView'] . 'index.php' : DIR['baseView'] . $page . '.php';
        $_SESSION['page'] = $view;
        header('Location: ' . DIR['socialnet']);
    }
}