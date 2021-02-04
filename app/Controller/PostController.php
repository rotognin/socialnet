<?php

namespace app\Controller;

use app\Model as Model;

class PostController
{

    static public function insert(array $data)
    {
        // Verificar se o conteúdo da postagem está em branco
        if ($data['text'] == ''){
            Log::message('Texto da postagem em branco.');
            Controller::mainAction();
        }

        $o_post = new Model\Post();
        $o_post->setFields($data);

        if ($o_post->write()){
            Log::write('Postagem cadastrada com sucesso!');
        } else {
            Log::write('Não foi possível gravar a postagem.');
        }

        Controller::mainAction();
    }

    static public function update(array $data)
    {
        $o_post = new Model\Post($data['id']);
        $o_post->rewrite($data);
    }

    static public function delete(array $data)
    {
        $o_post = new Model\Post($data['id']);
        if ($o_post->post['posUser'] == $_SESSION['userId']){
            $o_post->delete($data['id']);
        }
    }
}