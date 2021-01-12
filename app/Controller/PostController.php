<?php

namespace app\Controller;

use app\Model as Model;

class PostController
{

    static public function insert(array $data)
    {
        // Verificar se o conteúdo da postagem está em branco

        // "strip tags" e proteções


        $o_post = new Model\Post();
        $o_post->setFields($data);

        if ($o_post->write()){
            Log::message('Postagem cadastrada com sucesso!');
            header('Location: index.php');
        } else {
            Log::message('Não foi possível gravar a postagem.');
            Controller::mainAction();
        }
    }

    static public function update(array $data)
    {
        // A ser desenvolvido
    }
}