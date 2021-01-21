<?php

namespace app\Model;

class communitypost
{
    public $communityPost = array(
        'cpoId' => 0,
        'cpoIdCommunity' => 0,
        'cpoIdUser' => 0,
        'cpoDate' => 0,
        'cpoText' => ''
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

            // Continuar... pegar o resultado e chamar o loadArray

        }
    }
}