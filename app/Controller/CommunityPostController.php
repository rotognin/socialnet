<?php

namespace app\Controller;

use app\Model as Model;

class CommunityPostController{

    static public function insert(array $data)
    {
        if ($data['text'] == ''){
            Log::message('Texto da postagem em branco.');
            Controller::viewAction('communitypost');
            exit();
        }

        $o_communityPost = new Model\CommunityPost();
        $o_communityPost->setFields($data);
        if ($o_communityPost->write()){
            Controller::showcommunityAction(array(), array('comId' => $data['idCommunity']));
        } else {
            Log::message('Não foi possível gravar a postagem');
            Controller::viewAction('communitypost');
            exit();
        }

    }
}