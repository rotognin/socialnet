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

function autoload($class)
{   
    include_once($class . '.php');
}
spl_autoload_register('autoload');