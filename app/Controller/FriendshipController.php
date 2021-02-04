<?php

namespace app\Controller;

use app\Model as Model;

class FriendshipController
{
    static function addFriend(int $usuOrigin, int $usuDestination)
    {
        $o_friendship = new Model\Friendship();
        $friendshipStatus = $o_friendship->checkStatus($usuOrigin, $usuDestination);

        if ($friendshipStatus == 0){
            // A amizade ainda não existe ou está pendente para a origem aceitar
            $o_friendship->addFriend($usuOrigin, $usuDestination);
        } else {
            switch ($friendshipStatus)
            {
                case 1:
                    Log::message('O convite está pendente para aceitação.');
                    break;
                case 2:
                    Log::message('A amizade já existe.');
                    break;
                case 3:
                    Log::message('O pedido de amizade foi negado.');
                    break;
                case 4:
                    // Por enquanto... depois ver uma forma melhor de "desnegar"
                    // o pedido para quem negou
                    Log::message('A amizade foi negada');
                    break;
            }

        }


    }

    /**
     * Aceitar ou negar o pedido de amizade feita.
     * $friendshipStatus: 
     * 2 = Aceitou a amizade, 
     * 3 = Negou a amizade,
     * 4 = Desfez a amizade.
     */
    static function updateInvite(int $usuOrigin, int $usuDestination, int $friendshipStatus)
    {
        // 
    }
}