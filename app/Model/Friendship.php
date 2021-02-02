<?php

namespace app\Model;

use app\Controller as Controller;

class Friendship
{
    public $friendship = array(
        'friId' => 0,
        'friUserOrigin' => 0,
        'friUserDestination' => 0,
        'friDate' => '',
        'friStatus' => 0
    );

    public function __construct(int $friId = 0)
    {
        $this->friendship['friId'] = $friId;
        $this->load();
    }

    private function load()
    {
        if ($this->friendship['friId'] > 0){
            $sql = 'SELECT * FROM friendships_tb WHERE friId = ' . $this->friendship['friId'];
            $resutSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
            $result = $resultSet->fetchAll();

            if (!is_null($result)){
                $this->loadArray($result[0]);
            }
        }
    }

    public function loadArray(array $friendshipData)
    {
        foreach ($friendshipData as $field => $value)
        {
            $this->friendship[$field] = $value;
        }
    }

    /**
     * Listar as amizades de um usuário. Tipos de listagens: 
     * 1 - Amizades firmadas ($friStatus = 2);
     * 2 - Amizades pendentes para o usuário ($fristatus = 1, $friUserOrigin > 0) - 
     *     "eu solicitei a amizade";
     * 3 - Amizades pendentes a serem aceitas ($friStatus = 1, $friUserDestination > 0) - 
     *     "me solicitaram a amizade";
     * 4 - Amizades negadas para o usuário ($friStatus = 3, $friUserOrigin > 0) - 
     *     "me negaram a amizade";
     * 5 - Amizades negadas pelo usuário ($friStatus = 3, $friUserDestination > 0) - 
     *     "eu neguei a amizade";
     * 6 - Amizades desfeitas ($friStatus = 4, $friUserOrigin > 0 OU $friUserDestination > 0);
     */
    static public function list(int $userTarget, int $typeList = 1)
    {
        // Criar as constantes dos tipos a serem passados
        // Desenvolver a função para realizar a pesquisa no banco.
        $sql = '';
        $sql = 'SELECT f.friId, f.friUserOrigin, f.friUserDestination, f.friDate, f.friStatus, ' .
               'u1.usuId as "usuOriginId", u1.usuName as "usuOriginName", ' .
               'u1.usuCity as "usuOriginCity", u1.usuState as "usuOriginState", ' .
               'u2.usuId as "usuDestinationId", u2.usuName as "usuDestinationName", ' .
               'u2.usuCity as "usuDestinationCity", u2.usuState as "usuDestinationState" ' .
               'FROM friendships_tb f ' .
               'LEFT JOIN users_tb u1 ON u1.usuId = f.friUserOrigin ' .
               'LEFT JOIN users_tb u2 ON u2.usuId = f.friUserDestination ';

        switch ($typeList)
        {
            case FRI_TL_DONE:
                $sql .= 'WHERE f.friStatus = 2 AND (u1.usuId = :usuIdOrigin OR u2.usuId = :usuIdDestination)';
                break;

            case FRI_TL_PENDING_FROM:
                $sql .= 'WHERE f.friStatus = 1 AND (u1.usuId = :usuIdOrigin)';
                break;

            case FRI_TL_PENDING_TO:
                $sql .= 'WHERE f.friStatus = 1 AND (u2.usuId = :usuIdDestination)';
                break;

            case FRI_TL_DENIED_TO:
                $sql .= 'WHERE f.friStatus = 3 AND (u1.usuId = :usuIdOrigin)';
                break;

            case FRI_TL_DENIED_FROM:
                $sql .= 'WHERE f.friStatus = 3 AND (u2.usuId = :usuIdDestination)';
                break;

            case FRI_TL_UNDONE:
                $sql .= 'WHERE f.friStatus = 4 AND (u1.usuId = :usuIdOrigin OR u2.usuId = :usuIdDestination)';
                break;
        }

        $prepared = Connection::getConnection()->prepare($sql);

        switch ($typeList)
        {
            case FRI_TL_DONE:
                $prepared->bindValue('usuIdOrigin', $userTarget, \PDO::PARAM_INT);
                $prepared->bindValue('usuIdDestination', $userTarget, \PDO::PARAM_INT);
                break;

            case FRI_TL_PENDING_FROM:
                $prepared->bindValue('usuIdOrigin', $userTarget, \PDO::PARAM_INT);
                break;

            case FRI_TL_PENDING_TO:
                $prepared->bindValue('usuIdDestination', $userTarget, \PDO::PARAM_INT);
                break;

            case FRI_TL_DENIED_TO:
                $prepared->bindValue('usuIdOrigin', $userTarget, \PDO::PARAM_INT);
                break;

            case FRI_TL_DENIED_FROM:
                $prepared->bindValue('usuIdDestination', $userTarget, \PDO::PARAM_INT);
                break;

            case FRI_TL_UNDONE:
                $prepared->bindValue('usuIdOrigin', $userTarget, \PDO::PARAM_INT);
                $prepared->bindValue('usuIdDestination', $userTarget, \PDO::PARAM_INT);
                break;
        }

        $prepared->execute();
        return $prepared->fetchAll();
    }

    public function isFriend(int $user1, int $user2)
    {
        $sql = 'SELECT friUserOrigin, friUserDestination, friStatus ' .
               'FROM friendships_tb ' .
               'WHERE (friUserOrigin = :friUser1 AND friUserDestination = :friUser2) OR ' .
                     '(friUserOrigin = :friUser2 AND friUserDestination = :friUser1) AND ' .
                     'friStatus = 2';

        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('friUser1', $user1, \PDO::PARAM_INT);
        $prepared->bindValue('friUser2', $user2, \PDO::PARAM_INT);
        $prepared->execute();

        return ($prepared->rowCount() > 0);
    }
}