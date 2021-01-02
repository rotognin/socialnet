<?php

class Controller extends Log
{
    static function loginAction(array $data)
    {

        if ($data['login'] == ''){
            $_SESSION['message'] = 'Login em branco.';
            self::indexAction();
        }

        self::indexAction();
    }

    static function indexAction()
    {
        header('Location: ' . DIR['login']);
    }
}