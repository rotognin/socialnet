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
const COM_TL_ALL                  = 1;
const COM_TL_IDCOMMUNITY          = 2;
const COM_TL_USERPARTICIPATE      = 3;
const COM_TL_USERCREATE           = 4;
const COM_TL_SEARCHBYNAME         = 5;
const COM_TL_USERNOTPARTICIPATING = 6;

// Constantes para os tipos de listagens de amizades
const FRI_TL_DONE         = 1;
const FRI_TL_PENDING_FROM = 2;
const FRI_TL_PENDING_TO   = 3;
const FRI_TL_DENIED_TO    = 4;
const FRI_TL_DENIED_FROM  = 5;
const FRI_TL_UNDONE       = 6;

// Constantes do status de pedidos de amizades
const FRI_AT_ACCEPT = 2;
const FRI_AT_DENY   = 3;
const FRI_AT_UNDONE = 4;

echo '<script type="application/javascript">';
include_once __DIR__ . DS . 'functions.js';
echo '</script>';

function autoload($class)
{   
    include_once($class . '.php');
}
spl_autoload_register('autoload');