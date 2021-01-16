<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

define('DS', DIRECTORY_SEPARATOR);
define('DIR', array('controller' => 'app' . DS . 'Controller' . DS,
                    'model'      => 'app' . DS . 'Model' . DS,
                    'view'       => 'app' . DS . 'View' . DS,
                    'home'       => 'index.php',
                    'log'        => 'log' . DS . 'log.txt'
                   )
        );

// Constantes para os tipos de comunidades a serem listadas
const COM_TL_ALL = 1;
const COM_TL_IDCOMMUNITY = 2;
const COM_TL_USERPARTICIPATE = 3;
const COM_TL_USERCREATE = 4;
const COM_TL_SEARCHBYNAME = 5;

function autoload($class)
{   
    include_once($class . '.php');
}
spl_autoload_register('autoload');