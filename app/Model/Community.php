<?php

namespace app\Model;

use app\Controller as Controller;

class Community
{
    public $community = array(
        'comId'           => 0,
        'comName'         => '',
        'comDescription'  => '',
        'comDateCreation' => '',
        'comStatus'       => 0,
        'comAcceptance'   => 0,
        'comVisibility'   => 0,
        'comAdmUser'      => 0
    );

    public function __construct($comId = 0)
    {
        $this->community['comId'] = $comId;
        $this->load();
    }

    private function load()
    {
        if ($this->community['comId'] > 0){
            $sql = 'SELECT * FROM communities_tb WHERE comId = ' . $this->community['comId'];
            $resultSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
            $result = $resultSet->fetchAll();

            if (!is_null($result)){
                $this->loadArray($result[0]);
            }
        }
    }

    public function loadArray(array $communityData)
    {
        foreach ($communityData as $field => $value)
        {
            $this->community[$field] = $value;
        }
    }

    public function write()
    {
        $sql = 'INSERT INTO communities_tb (comName, comDescription, comStatus, comAcceptance, comVisibility, comAdmUser) ' .
               'VALUES (:comName, :comDescription, :comStatus, :comAcceptance, :comVisibility, :comAdmUser)';

        $connection = Connection::getConnection();
        $prepared = $connection->prepare($sql);
        $arrayExec = array('comName'        => $this->community['comName'],
                           'comDescription' => $this->community['comDescription'],
                           'comStatus'      => $this->community['comStatus'],
                           'comAcceptance'  => $this->community['comAcceptance'],
                           'comVisibility'  => $this->community['comVisibility'],
                           'comAdmUser'     => $this->community['comAdmUser']);

        foreach ($arrayExec as $key => $value)
        {
            if (is_int($value)){
                $prepared->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $prepared->bindValue($key, $value);
            }
        }

        $prepared->execute();
        return $connection->lastinsertid();
        //return ($prepared->rowCount() > 0);
    }

    public function rewrite(array $data)
    {
        $sql = 'UPDATE communities_tb SET ' ;
        $set = '';
        $arrayFields = array();

        foreach ($data as $key => $value)
        {
            // "key name modifier"
            $key = 'com' . ucfirst($key);

            if (array_key_exists($key, $this->community)){
                if ($value != $this->community[$key]){
                    $set .= $key . ' = :' . $key . ', ';
                    $arrayFields[$key] = $value;
                }
            }
        }

        if (empty($arrayFields)){
            // Se não existirem campos a serem atualizados, sair
            return true;
        }

        $set = substr($set, 0, -2);

        // IMPORTANTÍSSIMO!!! 
        $sql .= $set . ' WHERE comId = ' . $this->community['comId'];

        $prepared = Connection::getConnection()->prepare($sql);
        
        foreach($arrayFields as $key => $value)
        {
            if (is_int($value)){
                $prepared->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $prepared->bindValue($key, $value);
            }
        }

        $prepared->execute();

        return ($prepared->rowCount() > 0);
    }

    public function setFields(array $data)
    {
        foreach ($data as $key => $value)
        {
            // "Key name modifier"
            $key = 'com' . ucfirst($key);

            if (array_key_exists($key, $this->community)){
                $this->community[$key] = $value;
            }
        }
    }

    /**
     * Formas de buscar comunidades:
     * 1 - Listar todas existentes (raramente será utilizada);
     * 2 - Listar uma específica pelo ID;
     * 3 - Listar todas que um usuário participa;
     * 4 - Listar todas as criadas por um usuário específico;
     * 5 - Pesquisar por parte do nome;
     */
    public function list(int $typeList, int $comId = 0, int $userId = 0, string $comName = '', string $orderBy = 'ASC')
    {
        $sql = '';
        $sql = 'SELECT * FROM communities_tb ';

        switch ($typeList)
        {
            case COM_TL_ALL:
                break;
            case COM_TL_IDCOMMUNITY:
                $sql .= 'WHERE comId = :comId ';
                break;
            case COM_TL_USERPARTICIPATE:
                $sql .= 'WHERE comId = (SELECT parIdCommunity FROM participations_tb WHERE parIdUser = :parIdUser) ';
                break;
            case COM_TL_USERCREATE:
                $sql .= 'WHERE comAdmUser = :comAdmUser ';
                break;
            case COM_TL_SEARCHBYNAME:
                if (strlen($comName) < 3){
                    return array();
                }

                $sql .= 'WHERE comName like :comName ';
                break;
        }

        $sql .= 'ORDER BY comId ' . $orderBy;

        $prepare = Connection::getConnection()->prepare($sql);

        switch ($typeList)
        {
            case COM_TL_ALL:
                break;
            case COM_TL_IDCOMMUNITY:
                $prepare->bindValue('comId', $comId, \PDO::PARAM_INT);
                break;
            case COM_TL_USERPARTICIPATE:
                $prepare->bindValue('parIdUser', $userId, \PDO::PARAM_INT);
                break;
            case COM_TL_USERCREATE:
                $prepare->bindValue('comAdmUser', $userId, \PDO::PARAM_INT);
                break;
            case COM_TL_SEARCHBYNAME:
                $prepare->bindValue('comName', '%' . $comName . '%', \PDO::PARAM_STR);
                break;
        }

        $prepare->execute();

        return $prepare->fetchAll();
    }

}