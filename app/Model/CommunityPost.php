<?php

namespace app\Model;

class CommunityPost
{
    public $communityPost = array(
        'cpoId'          => 0,
        'cpoIdCommunity' => 0,
        'cpoIdUser'      => 0,
        'cpoDate'        => 0,
        'cpoText'        => ''
    );

    public function __construct(int $cpoId = 0)
    {
        $communityPost['cpoId'] = $cpoId;
        $this->load();
    }

    private function load()
    {
        if ($this->communityPost['cpoId'] > 0) {
            $sql = 'SELECT * FROM communityposts_tb WHERE cpoId = :cpoId'; // . $this->communityPost['cpoId'];
            $prepared = Connection::getConnection()->prepare($sql);
            $prepared->bindValue('cpoId', $this->communityPost['cpoId'], \PDO::PARAM_INT);
            $prepared->execute();

            $result = $prepared->fetchAll();
            if (!is_null($result)){
                $this->loadArray($result[0]);
            }
        }
    }

    public function loadArray(array $communityPostData)
    {
        foreach ($communityPostData as $field => $value)
        {
            $this->communityPost[$field] = $value;
        }
    }

    public function write()
    {
        $sql = 'INSERT INTO communityposts_tb (cpoIdCommunity, cpoIdUser, cpoText) ' .
               'VALUES (:cpoIdCommunity, :cpoIdUser, :cpoText)';

        $connection = Connection::getConnection();
        $prepared = $connection->prepare($sql);
        $arrayExec = array('cpoIdCommunity' => $this->communityPost['cpoIdCommunity'],
                           'cpoIdUser'      => $this->communityPost['cpoIdUser'],
                           'cpoText'        => $this->communityPost['cpoText']);

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
    }

    public function setFields(array $data)
    {
        foreach ($data as $key => $value)
        {
            // "Key name modifier"
            $key = 'cpo' . ucfirst($key);

            if (array_key_exists($key, $this->communityPost)){
                $this->communityPost[$key] = $value;
            }
        }
    }

    /**
     * Listar postagens de uma comunidade específica
     */
    static public function listPosts(int $communityId)
    {
        if (!is_int($communityId)){
            return false;
        }

        $sql = 'SELECT cpo.cpoId, com.comId, com.comName, com.comDescription, com.comStatus, usu.usuId, usu.usuName, ' .
               'cpo.cpoDate, cpo.cpoText FROM communityposts_tb cpo ' .
               'LEFT JOIN communities_tb com ON com.comId = cpo.cpoIdCommunity ' .
               'LEFT JOIN users_tb usu ON usu.usuId = cpo.cpoIdUser ' .
               'WHERE com.comId = :communityId ORDER BY cpo.cpoId DESC';

        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->bindValue('communityId', $communityId, \PDO::PARAM_INT);
        $prepared->execute();

        return $prepared->fetchAll();
    }
}