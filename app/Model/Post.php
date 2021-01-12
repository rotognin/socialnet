<?php

namespace app\Model;

use app\Controller as Controller;

class Post
{
    public $post = array('posId'         => 0,
                         'posUser'       => 0,
                         'posVisibility' => '',
                         'posText'       => '',
                         'posDate'       => '');

    public function __construct($posId = 0)
    {
        $this->post['posId'] = $posId;
        $this->load();
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

    private function loadArray(array $postData)
    {
        foreach ($postData as $field => $value)
        {
            $this->post[$field] = $value;
        }
    }
}