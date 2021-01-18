<?php

namespace app\Controller;

use app\Model as Model;

class CommunityController
{

    static public function insert(array $data)
    {
        // Verificar se o conteúdo dos textos estão em branco
        if ($data['name'] == ''){
            Log::message('Nome da comunidade em branco.');
            Controller::viewAction('community');
            exit();
        }

        if ($data['description'] == ''){
            Log::message('Descrição da comunidade em branco.');
            Controller::viewAction('community');
            exit();
        }

        $o_community = new Model\Community();
        $o_community->setFields($data);
        $insertId = $o_community->write();

        if ($insertId > 0){
            Log::write('Comunidade criada com sucesso! ID = ' . $insertId);
        } else {
            Log::write('Não foi possível criar a comunidade.');
        }

        return $insertId;
    }

    static public function associateUser(int $communityId, int $userId)
    {
        // Criar a associação da comunidade com o usuário

        
    }

    static public function update(array $data)
    {
        $o_community = new Model\Community($data['id']);
        $o_community->rewrite($data);
    }
}