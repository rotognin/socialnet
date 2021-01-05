<?php

namespace app\Model;

use app\Controller as Controller;

class User
{
    public $usuId;
    public $usuName;

    public function __construct($usuId = 0)
    {
        $this->usuId = $usuId;
        $this->load();
    }

    public function login($login, $password)
    {
        if (preg_match('/[^A-Za-z0-9]/', $login)){
            Controller\Log::message('Usuário não cadastrado. (Caractres inválidos)');
            return false;
        }

        $passEncrypted = sha1($password);
        $sql = 'SELECT * FROM users_tb WHERE usuLogin = "' . $login . '" AND usuPassword = "' . $passEncrypted . '"';
        $resultSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
        $result = $resultSet->fetchAll();

        if (empty($result)){
            Controller\Log::message('Usuário não cadastrado.');
            return false;
        }

        if ($result[0]['usuStatus'] <> 1){
            $usuStatus = ($result[0]['usuStatus'] == 2) ? 'Inativo' : 'Bloqueado';
            Controller\Log::message('Usuário não pode entrar no sistema. Status: ' . $usuStatus );
            return false;
        }

        $this->usuId = $result[0]['usuId'];
        $this->usuName = $result[0]['usuName'];

        return true;
    }

    private function load()
    {
        if ($this->usuId > 0){
            $sql = 'SELECT * FROM users_tb WHERE usuId = ' . $this->usuId;
            $resultSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
            $result = $resultSet->fetchAll();

            if (!is_null($result)){
                print_r($result);
                $this->usuName = $result[0]['usuName'];
            }
        }
        
    }
}