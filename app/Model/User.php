<?php

namespace app\Model;

use app\Controller as Controller;

class User
{
    public $user = array('usuId' => 0,
                         'usuName' => '',
                         'usuLogin' => '',
                         'usuPassword' => '',
                         'usuStatus' => 0,
                         'usuDate' => ''
                        );

    public function __construct($usuId = 0)
    {
        $this->user['usuId'] = $usuId;
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

        $this->loadArray($result[0]);

        return true;
    }

    private function loadArray(array $userData)
    {
        foreach ($userData as $field => $value)
        {
            $this->user[$field] = $value;
            //Controller\Log::write($field . ' = ' . $value);
        }
    }

    private function load()
    {
        if ($this->user['usuId'] > 0){
            $sql = 'SELECT * FROM users_tb WHERE usuId = ' . $this->user['usuId'];
            $resultSet = Connection::getConnection()->query($sql, \PDO::FETCH_ASSOC);
            $result = $resultSet->fetchAll();

            if (!is_null($result)){
                //print_r($result);
                $this->usuName = $result[0]['usuName'];
            }
        }
    }

    public function write()
    {
        $sql = 'INSERT INTO users_tb (usuName, usuLogin, usuPassword) ' .
               'VALUES (:usuName, :usuLogin, :usuPassword)';
        $prepared = Connection::getConnection()->prepare($sql);
        return $prepared->execute(array('usuName'     => $this->user['usuName'],
                                        'usuLogin'    => $this->user['usuLogin'],
                                        'usuPassword' => $this->user['usuPassword']));
    }

    public function loginExists($login)
    {
        $sql = 'SELECT usuLogin FROM users_tb WHERE usuLogin = :login';
        $prepared = Connection::getConnection()->prepare($sql);
        $prepared->execute(array('login' => $login));
        $result = $prepared->fetchAll();

        return (!empty($result));
    }
}