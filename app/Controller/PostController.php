<?php

namespace app\Controller;

use app\Model as Model;

class PostController
{

    static public function insert(array $data)
    {
        // Verificar se o conteúdo da postagem está em branco

        // "strip tags" e proteções


        $o_post = new Model\Post($data);
        if ($o_post->write()){
            Log::message('Postagem cadastrada com sucesso!');

            // Verificar de onde veio para setar o "Location" corretamente.
            // Poderá ser uma postagem de usuário, para um usuário, ou em uma comunidade, ou 
            // uma resposta a uma postagem nesses lugares.

            header('Location: index.php');
        } else {
            Log::message('Não foi possível gravar a postagem.');

            Controller::mainAction();
            //header('Location: socialnet.php');
        }
    }

    static public function update(array $data)
    {
        // A ser desenvolvido
    }
}