<?php

namespace app\Controller;

use app\Model as Model;

class UserController
{
    static public function newUser(array $data)
    {
        if (!Filters::commomText($data['name'])){
            Log::message('Caracteres inválidos no nome');
            header('Location: createuser.php');
            exit();
        }
        
        if ($data['name'] == '' || $data['login'] == '' || $data['password'] == ''){
            Log::message('Existem campos em branco');
            header('Location: createuser.php');
            exit();
        }

        // Ver se o login já está sendo usado por outra pessoa
        $o_user = new Model\User();
        if ($o_user->loginExists($data['login'])){
            Log::message('Este login já está sendo utilizado.');
            header('Location: createuser.php');
            exit();
        }

        $data['password'] = sha1($data['password']);
        $o_user->setFields($data);

        if ($o_user->write()){
            Log::message('Usuário cadastrado com sucesso!');
            header('Location: index.php');
        } else {
            Log::message('Não foi possível cadastrar o usuário.');
            header('Location: createuser.php');
        }
    }

    static function updateUser(array $data)
    {
        $o_user = new Model\User($data['id']);
        $o_user->rewrite($data);
    }
}