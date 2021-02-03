<?php

namespace app\Controller;

use app\Model as Model;

class FriendshipController
{
    static function addFriend(int $usuOrigin, int $usuDestination)
    {
        $o_friendship = new Model\Friendship();

        // **** Pensar melhor nessa lógica, pois pode ser que o destino já
        // tenha negado o pedido de amizade antes, ou a origem, ou a amizade
        // tenha sido desfeita... Avaliar as condições.

        // Verificar se a amizade já foi solicitada/negada/desfeita.
        // Se a amizade já foi solicitada pelo destino à origem e está pendente, aceitar a amizade ao
        // invés de adicionar.
        // Deixar a amizade em aberto para quem recebeu o convite ver se aceita ou não
        $friendshipStatus = $o_friendship->checkStatus($usuOrigin, $usuDestination);

        if ($friendshipStatus == 0){
            // A amizade ainda não existe ou está pendente para a origem aceitar

        } else {
            // Se o status estiver como 3, 

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