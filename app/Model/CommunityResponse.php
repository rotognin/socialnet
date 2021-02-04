<?php

namespace app\Model;

class CommunityResponse
{
    public $communityResponse = array(
        'cprId'     => 0,
        'cprIdCpo'  => 0,
        'cprIdUser' => 0,
        'cprDate'   => '',
        'cprText'   => ''
    );

    public function __construct(int $cprId)
    {
        $this->communityResponse['cprId'] = $cprId;
        $this->load();
    }

    private function load()
    {
        if ($this->communityResponse['cprId'] > 0) {
            $sql = 'SELECT * FROM communityresponses_tb WHERE cprId = :cprId';
            $prepared = Connection::getConnection()->prepare($sql);
            $prepared->bindValue('cprId', $this->communityResponse['cprId'], \PDO::PARAM_INT);
            $prepared->execute();

            $result = $prepared->fetchAll();
            if (!is_null($result)){
                $this->loadArray($result[0]);
            }
        }
    }

    public function loadArray(array $communityResponseData)
    {
        foreach ($communityResponseData as $field => $value)
        {
            $this->communityResponse[$field] = $value;
        }
    }
    
}