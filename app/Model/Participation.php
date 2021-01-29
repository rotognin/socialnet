<?php

namespace app\Model;

use app\Controller as Controller;

class Participation 
{
    public $participation = array(
        'parId'          => 0,
        'parIdCommunity' => 0,
        'parIdUser'      => 0,
        'parSituation'   => 0,
        'parDate'        => ''
    );

    public function __construct(array $data = [])
    {
        if (!empty($data)){
            foreach ($data as $key => $value)
            {
                $this->participation[$key] = $value;
            }
        }
    }

    public function write(array $data)
    {
        $sql = 'INSERT INTO participations_tb (parIdCommunity, parIdUser, parSituation) ' .
               'VALUES (:parIdCommunity, :parIdUser, :parSituation)';

        $connection = Connection::getConnection();
        $prepared = $connection->prepare($sql);

        foreach ($data as $key => $value)
        {
            if (is_int($value)) {
                $prepared->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $prepared->bindValue($key, $value);
            }              
        }

        $prepared->execute();
        return $connection->lastinsertid();
    }

    /**
     * Listar todas as comunidades que um usuário participa
     */
    public function listCommunities(int $userId)
    {
        $sql = 'SELECT * FROM participations_tb WHERE parUserId = :parUserId';
        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('parUserId', $userId, \PDO::PARAM_INT);
        $prepared->execute();

        return $prepared->fetchAll();
    }

    /**
     * Listar todos os usuários de uma comunidade que estejam ativos nela
     */
    static public function listParticipants(int $communityId)
    {
        $sql = 'SELECT u.usuId, u.usuName, u.usuCity, u.usuState, p.parSituation, c.comAdmUser ' .
               'FROM users_tb u ' .
               'LEFT JOIN participations_tb p ON p.parIdUser = u.usuId ' .
               'LEFT JOIN communities_tb c ON p.parIdCommunity = c.comId ' .
               'WHERE p.parIdCommunity = :parIdCommunity AND p.parSituation = 1';
        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('parIdCommunity', $communityId, \PDO::PARAM_INT);
        $prepared->execute();

        return $prepared->fetchAll();
    }

    /**
     * Verificar se um usuário está participando de uma comunidade
     */
    static public function isParticipating(int $userId, int $communityId)
    {
        $sql = '';
        $sql = 'SELECT p.parId FROM participations_tb p ' .
               'WHERE p.parIdUser = :parIdUser AND p.parIdCommunity = :parIdCommunity';
        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('parIdUser', $userId, \PDO::PARAM_INT);
        $prepared->bindValue('parIdCommunity', $communityId, \PDO::PARAM_INT);
        $prepared->execute();

        return ($prepared->rowCount() > 0);

    }
}