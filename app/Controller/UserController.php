<?php

namespace app\Controller;

use app\Model as Model;

class UserController
{
    static public function newUser($data)
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

        $o_user->user['usuName'] = $data['name'];
        $o_user->user['usuLogin'] = $data['login'];
        $o_user->user['usuPassword'] = sha1($data['password']);

        if ($o_user->write()){
            Log::message('Usuário cadastrado com sucesso!');
            header('Location: index.php');
        } else {
            Log::message('Não foi possível cadastrar o usuário.');
            header('Location: createuser.php');
        }

    }
}