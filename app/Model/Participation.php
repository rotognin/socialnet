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
     * Listar todas as comunidades de um usuário
     */
    public function listCommunities(int $userId)
    {
        $sql = 'SELECT * FROM participations_tb WHERE parUserId = :parUserId';
        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('parUserId', $userId, \PDO::PARAM_INT);
        $prepared->execute();

        return $prepared->fetch_all();
    }
}