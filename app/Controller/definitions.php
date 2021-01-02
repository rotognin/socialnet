<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

define('DS', DIRECTORY_SEPARATOR);
define('DIR', array('controller' => '..' . DS . '..' . DS . 'app' . DS . 'Controller' . DS,
                    'model'      => '..' . DS . '..' . DS . 'app' . DS . 'Model' . DS,
                    'view'       => '..' . DS . '..' . DS . 'app' . DS . 'View' . DS,
                    'baseView'   => 'app' . DS . 'View' . DS,
                    'login'      => '..' . DS . '..' . DS,
                    'socialnet'  => '..' . DS . '..' . DS . 'socialnet.php',
                    'log'        => '..' . DS . '..' . DS . 'log' . DS
                   )
        );

function autoload($class)
{
    include_once($class . '.php');
}
spl_autoload_register('autoload');