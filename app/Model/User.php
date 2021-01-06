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
                         'usuDate' => '',
                         'usuCity' => '',
                         'usuState' => ''
                        );

    public function __construct($usuId = 0)
    {
        $this->user['usuId'] = $usuId;
        $this->load();
    }

    public function setFields(array $data)
    {
        foreach ($data as $key => $value)
        {
            // "Key name modifier"
            $key = 'usu' . ucfirst($key);

            if (array_key_exists($key, $this->user)){
                $this->user[$key] = $value;
            }
        }
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
                $this->loadArray($result[0]);
            }
        }
    }

    public function write()
    {
        $sql = 'INSERT INTO users_tb (usuName, usuLogin, usuPassword, usuCity, usuState) ' .
               'VALUES (:usuName, :usuLogin, :usuPassword, :usuCity, :usuState)';
        $prepared = Connection::getConnection()->prepare($sql);
        return $prepared->execute(array('usuName'     => $this->user['usuName'],
                                        'usuLogin'    => $this->user['usuLogin'],
                                        'usuPassword' => $this->user['usuPassword'],
                                        'usuCity'     => $this->user['usuCity'],
                                        'usuState'    => $this->user['usuState']));
    }

    public function rewrite(array $data)
    {
        // Futuramente extrair essa estrutura de montagem do SQL para um classe
        // abstrata onde as outras tabelas poderão usar a mesma lógica
        $sql = 'UPDATE users_tb SET ' ;
        $set = '';

        foreach ($data as $key => $value)
        {
            // "key name modifier"
            $key = 'usu' . ucfirst($key);

            if (array_key_exists($key, $this->user)){
                if ($value != $this->user[$key]){
                    // Estou montando os valores do UPDATE usando parâmetros para o Prepare do PDO
                    $set .= $key . ' = :' . $key . ' ';
                }
            }
        }

        if (empty($set)){
            // Se não existirem campos a serem atualizados, sair
            return;
        }

        // IMPORTANTÍSSIMO!!! 
        $sql .= ' WHERE usuId = ' . $this->user['usuId'];

        // Prosseguir com a atualização do usuário



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