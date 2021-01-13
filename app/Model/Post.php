<?php

namespace app\Model;

use app\Controller as Controller;

class Post
{
    public $post = array('posId'         => 0,
                         'posUser'       => 0,
                         'posVisibility' => 0,
                         'posText'       => '',
                         'posDate'       => '');

    public function __construct($posId = 0)
    {
        $this->post['posId'] = $posId;
        $this->load();
    }

    public function visibilityDescription(int $visibility)
    {
        $description = '';

        switch ($visibility){
            case 1:
                $description = 'Pública';
                break;
            case 2:
                $description = 'Apenas amigos';
                break;
            case 3:
                $description = 'Particular';
                break;
        }

        return $description;
    }
    
    private function load()
    {
        if ($this->post['posId'] > 0){
            $sql = 'SELECT * FROM posts_tb WHERE posId = ' . $this->post['posId'];
            $resultSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
            $result = $resultSet->fetchAll();

            if (!is_null($result)){
                $this->loadArray($result[0]);
            }
        }
    }

    public function loadArray(array $postData)
    {
        foreach ($postData as $field => $value)
        {
            $this->post[$field] = $value;
        }
    }

    public function write()
    {
        $sql = 'INSERT INTO posts_tb (posUser, posVisibility, posText) ' .
               'VALUES (:posUser, :posVisibility, :posText)';

        $prepared = Connection::getConnection()->prepare($sql);
        $arrayExec = array('posUser'       => $this->post['posUser'],
                           'posVisibility' => $this->post['posVisibility'],
                           'posText'       => $this->post['posText']);

        foreach ($arrayExec as $key => $value)
        {
            Controller\Log::write($key . ' - ' . $value);
            if (is_int($value)){
                $prepared->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $prepared->bindValue($key, $value);
            }
        }

        /**
         * Estava dando muitos erros e não estava gravando a postagem
         * Primeiro: eu estava nomeando errado os parâmetros na view
         * Segundo: valores inteiros estavam sendo tratados como string
         * Terceiro: estava usando "bindParam" em vez de "bindValue"
         */
        $prepared->execute();
        return ($prepared->rowCount() > 0);
    }

    public function listAll(int $userId, string $orderBy = 'ASC')
    {
        $sql = 'SELECT * FROM posts_tb WHERE posUser = :posUser ORDER BY posId ' . $orderBy;
        $prepare = Connection::getConnection()->prepare($sql);
        $prepare->bindValue('posUser', $userId, \PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function setFields(array $data)
    {
        foreach ($data as $key => $value)
        {
            // "Key name modifier"
            $key = 'pos' . ucfirst($key);

            if (array_key_exists($key, $this->post)){
                $this->post[$key] = $value;
            }
        }
    }
}