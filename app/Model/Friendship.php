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

        switch ($typeList)
        {
            case FRI_TL_DONE:
                $sql = 'SELECT f.friId, f.friUserOrigin, f.friUserDestination, f.friDate, f.friStatus, ' .
                       'u1.usuNome as "usuOrigin", u2.usuNome as "usuDestination" ' .
                       'FROM friendships_tb f ' .
                       'LEFT JOIN users_tb u1 ON u1.usuId = f.friUserOrigin ' .
                       'LEFT JOIN users_tb u2 ON u2.usuId = f.friUserDestination ' .
                       'WHERE f.friStatus = 2';

                       /**
                        * SELECT f.friId, f.friUserOrigin, f.friUserDestination, f.friDate, f.friStatus, 
                          u1.usuId, u1.usuName as "usuOrigin", u2.usuId, u2.usuName as "usuDestination" 
                          FROM friendships_tb f 
                          LEFT JOIN users_tb u1 ON u1.usuId = f.friUserOrigin 
                          LEFT JOIN users_tb u2 ON u2.usuId = f.friUserDestination 
                          WHERE f.friStatus = 2 AND (u1.usuId = 1 OR u2.usuId = 1)
                        */
                break;

        }


    }
}