<?php

namespace app\Controller;

use app\Model as Model;

class ParticipationController
{
    /**
     * Associa um usuário a uma comunidade
     * @var int communityId
     * @returns string
     */
    static public function associateUser(int $communityId, int $userId)
    {
        // Criar a associação da comunidade com o usuário
        if (!is_int($communityId) || $communityId == 0){
            return 'ID da comunidade zerado.';
        }

        if (!is_int($userId) || $userId == 0){
            return 'ID do usuário zerado.';
        }

        $data = array('parIdCommunity' => $communityId, 'parIdUser' => $userId, 'parSituation' => 1);
        $o_participation = new Model\Participation();
        $idParticipation = $o_participation->write($data);

        $returnMessage = '';
        return (is_int($idParticipation));
    }
}